FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer dentro del contenedor
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache
    && chmod -R 755 /var/www/html/vendor

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
