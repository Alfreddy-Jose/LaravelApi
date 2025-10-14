FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY composer.json composer.lock ./

# Configuración específica para conexiones lentas
RUN composer config -g process-timeout 3000 && \
    composer config -g github-protocols https && \
    composer global require hirak/prestissimo --no-plugins --no-scripts

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Ejecutar scripts después
RUN composer run-script post-install-cmd

COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=8000