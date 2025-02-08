#!/bin/bash
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan cache:clear
php artisan route:cache
php artisan view:cache
php artisan storage:link -q
