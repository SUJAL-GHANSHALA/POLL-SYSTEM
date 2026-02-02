#!/bin/sh

echo "🚀 Running migrations..."
php artisan migrate --force

echo "🌱 Seeding database..."
php artisan db:seed --force

echo "🧹 Clearing cache..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear

echo "🚀 Starting Apache..."
exec apache2-foreground
