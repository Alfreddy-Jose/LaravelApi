FROM php:8.2-apache

WORKDIR /var/www/html

# 1. Instala dependencias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libonig-dev \
    libxml2-dev zip unzip libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd && \
    a2enmod rewrite

# 2. Configura Composer y copia proyecto
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

# 3. Instala dependencias
RUN composer install --no-dev --optimize-autoloader

# 4. Configura permisos (CRUCIAL)
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# 5. Configura Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 6. Limpia y regenera cachés
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan view:cache && \
    php artisan route:cache

# 7. Script de inicio con migraciones
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]