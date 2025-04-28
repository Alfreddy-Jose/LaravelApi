
FROM php:8.2-apache

WORKDIR /var/www/html

# 1. Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libonig-dev \
    libxml2-dev zip unzip libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd && \
    a2enmod rewrite

# Configuración SSL para PostgreSQL
RUN echo "extension=pdo_pgsql" >> /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini && \
echo "extension=openssl" >> /usr/local/etc/php/conf.d/docker-php-ext-openssl.ini

# 2. Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copia solo lo necesario para composer install
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 4. Copia el resto del proyecto
COPY . .

# 5. Configura permisos
RUN mkdir -p storage/logs && \
    touch storage/logs/laravel.log && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# 6. Configura Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 7. Mueve los comandos de Artisan al script de inicio
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]