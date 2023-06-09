#!/usr/bin/env bash
echo "Running composer"
composer update
composer global require hirak/prestissimo
composer install --ignore-platform-reqs --no-dev --working-dir=/var/www/html/public

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force