# 1. Verificación alternativa de conexión PostgreSQL (sin nc)
if ! php -r "try {new PDO('pgsql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD');} catch(Exception \$e) {exit(1);}"; then
    echo "Error: No se puede conectar a PostgreSQL"
    exit 1
fi

# 2. Genera clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
  php artisan key:generate
fi

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