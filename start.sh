#!/bin/bash

# Instala dependencias de Composer (sin dev)
composer install --optimize-autoloader --no-dev

# Genera el APP_KEY solo si no está definido
if [ -z "${APP_KEY}" ]; then
  php artisan key:generate
fi

# Ejecuta migraciones y seeders (opcional)
php artisan migrate --force

# Limpieza de caché y optimización
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Optimización para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Si usas storage (archivos públicos)
php artisan storage:link

# Inicia el servidor de Laravel
php artisan serve --host=0.0.0.0 --port=$PORT