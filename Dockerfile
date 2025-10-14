FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libpng-dev \
    libzip-dev \
    postgresql-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    netcat-openbsd

# Configurar extensiones de PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    xml

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de composer primero
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader

# Copiar el resto del código
COPY . .

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000

# Comando de inicio
CMD sh -c "while ! nc -z \$DB_HOST \$DB_PORT; do sleep 1; done && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"