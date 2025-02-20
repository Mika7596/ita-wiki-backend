#!/bin/sh
set -e

echo "Cleaning up old Laravel cache..."
if [ -f /var/www/html/bootstrap/cache/config.php ]; then
    rm /var/www/html/bootstrap/cache/config.php
fi

echo "Installing Composer dependencies..."
composer install

if [ ! -f .env ]; then
    echo "[WARNING] - .env File Not Found! Using .env.docker File as .env"
    cp .env.docker .env
fi

# Wait for the database to be ready before running migrations
echo "Waiting for database connection..."
until php artisan migrate --force; do
    echo "Database not ready. Retrying in 5 seconds..."
    sleep 5
done

echo "Generating application key..."
php artisan key:generate --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
if [ -L /var/www/html/public/storage ]; then
    echo "Removing existing storage link..."
    rm /var/www/html/public/storage
fi

echo "Generating storage link..."
php artisan storage:link
chmod -R u+w storage

echo "Starting PHP-FPM..."
exec php-fpm
