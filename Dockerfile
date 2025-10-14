FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias para Laravel
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

# Definir directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto (incluido vendor/)
COPY . .

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \

# Exponer el puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
