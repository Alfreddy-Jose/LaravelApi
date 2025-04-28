# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias del sistema
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

# Copia el proyecto (ignorando lo especificado en .dockerignore)
COPY . .

# Instala dependencias de Composer (sin dev)
RUN composer install --no-dev --optimize-autoloader

# Configura permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Configura Apache para Laravel
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Optimización de Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Script para ejecutar migraciones y luego iniciar Apache
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Puerto expuesto
EXPOSE 80

# Añade esto ANTES del CMD final
RUN mkdir -p storage/logs && \
    touch storage/logs/laravel.log && \
    chown -R www-data:www-data storage && \
    chmod -R 775 storage

# Comando de inicio (ejecuta migraciones y luego inicia Apache)
CMD ["/usr/local/bin/start.sh"]