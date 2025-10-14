# Etapa 1: Construcción (instala dependencias)
FROM composer:2.7 AS build

WORKDIR /app

# Copiamos solo los archivos necesarios para que composer cachee dependencias correctamente
COPY composer.json composer.lock ./

# Instalamos dependencias de producción
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Copiamos el resto del proyecto
COPY . .

---

# Etapa 2: Imagen final con PHP-FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar archivos desde la etapa de build (ya con vendor)
WORKDIR /var/www/html
COPY --from=build /app ./

# Configurar permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Exponer el puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
