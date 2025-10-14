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

# Copia solo los archivos de composer primero (para mejor uso de cache)
WORKDIR /var/www/html
COPY composer.json composer.lock ./

# Instala dependencias de PHP con mayor memoria
RUN php -d memory_limit=-1 /usr/bin/composer install --no-interaction --prefer-dist --optimize-autoloader

# Copia el resto del código de la aplicación
COPY . .

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expone el puerto 8000
EXPOSE 8000

# Refresca la base de datos y ejecuta seeders en cada despliegue
CMD php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=8000