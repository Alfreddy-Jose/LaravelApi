FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Composer - usa la versión más reciente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura variables de entorno
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_PROCESS_TIMEOUT=600

WORKDIR /var/www/html

# PRIMERO: Copia solo los archivos de composer
COPY composer.json composer.lock ./

# SEGUNDO: Instala dependencias con verificación
RUN echo "=== INICIANDO COMPOSER INSTALL ===" && \
    # Verifica que los archivos existen
    ls -la composer.* && \
    # Limpia cache de composer
    composer clear-cache && \
    # Instala dependencias con verificación de éxito
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev || \
    (echo "=== PRIMER INTENTO FALLÓ ===" && \
     sleep 10 && \
     echo "=== REINTENTANDO ===" && \
     composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev)

# VERIFICA que las dependencias se instalaron
RUN echo "=== VERIFICANDO INSTALACIÓN ===" && \
    ls -la vendor/ && \
    ls -la vendor/composer/ && \
    echo "=== DEPENDENCIAS INSTALADAS ==="

# TERCERO: Copia el resto del código
COPY . .

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=8000