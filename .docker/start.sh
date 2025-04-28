# 1. Limpia cachés antiguos
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 2. Genera nuevos cachés (solo en producción)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Ejecuta migraciones (opcional)
php artisan migrate --force

# Ejecuta seeds
php artisan db:seed --force

# 4. Inicia Apache
exec apache2-foreground