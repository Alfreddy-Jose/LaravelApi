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

# Instala Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Configura variables de entorno para debugging
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_DEBUG=1
ENV COMPOSER_PROCESS_TIMEOUT=2000

WORKDIR /var/www/html

# Copia archivos de composer
COPY composer.json composer.lock ./

# Intenta instalar con múltiples estrategias y logging
RUN echo "=== INICIANDO INSTALACIÓN DE COMPOSER ===" && \
    php -v && \
    composer --version && \
    composer diagnose && \
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --verbose 2>&1 | tee /tmp/composer.log || \
    (echo "=== PRIMER INTENTO FALLÓ, REINTENTANDO ===" && \
    composer clear-cache && \
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --verbose 2>&1 | tee /tmp/composer_retry.log)

# Muestra el log de composer
RUN if [ -f /tmp/composer.log ]; then echo "=== LOG DEL PRIMER INTENTO ===" && cat /tmp/composer.log; fi
RUN if [ -f /tmp/composer_retry.log ]; then echo "=== LOG DEL REINTENTO ===" && cat /tmp/composer_retry.log; fi

COPY . .

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=8000