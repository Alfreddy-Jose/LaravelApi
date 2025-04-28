# Verifica conexión a PostgreSQL
nc -z $DB_HOST $DB_PORT || exit 1

# 1. Limpia cachés antiguos
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Configuración de sesiones para PostgreSQL
php artisan config:set SESSION_DRIVER=database
php artisan config:set SESSION_CONNECTION=pgsql

# 2. Asegura permisos finales
chown -R www-data:www-data storage
chmod -R 775 storage

# 3. Genera nuevos cachés (solo en producción)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Ejecuta migraciones (opcional)
php artisan session:table
php artisan migrate --force

# 5. Ejecuta seeds
php artisan db:seed --force

# 6. Inicia Apache
exec apache2-foreground

#!/bin/bash