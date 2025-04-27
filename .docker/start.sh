#!/bin/bash

# Ejecuta migraciones
php artisan
# Ejecuta seeds
php artisan db:seed --force

# Inicia Apache
exec apache2-foreground