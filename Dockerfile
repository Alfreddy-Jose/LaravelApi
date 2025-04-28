# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias del sistema (incluyendo PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev  netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite

# Configuración SSL para PostgreSQL
RUN echo "extension=pdo_pgsql" >> /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini && \
    echo "extension=openssl" >> /usr/local/etc/php/conf.d/docker-php-ext-openssl.ini

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto (ignorando lo especificado en .dockerignore)
COPY . .

# Instala dependencias de Composer (sin dev)
RUN composer install --no-dev --optimize-autoloader

# Configura permisos para Laravel
RUN mkdir -p storage/logs && \
    touch storage/logs/laravel.log && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Configura Apache para Laravel
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Script de inicio
COPY .docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Elimina cualquier referencia a SQLite
RUN if [ -f database/database.sqlite ]; then rm database/database.sqlite; fi

# Puerto expuesto
EXPOSE 80

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]