FROM php:8.3-apache

WORKDIR /var/www/html

# Instala dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto (ignorando archivos con .dockerignore)
COPY . .

# Instala dependencias de Composer (sin dev)
#RUN composer install --no-dev --optimize-autoloader

# Configura permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Configura Apache para Laravel
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Optimización de Laravel
RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 80
CMD sh -c ["php artisan migrate --force && apache2-foreground"]