#!/bin/bash
# Shared Hosting Deployment Script for GusiiLyrics.com

echo "🚀 Starting GusiiLyrics Shared Hosting Deployment..."

# 1. Pull latest code from GitHub
git pull origin main

# 2. Install production Composer dependencies
composer install --no-dev --optimize-autoloader

# 3. Run database migrations & seeders
php artisan migrate --force --seed

# 4. Optimize Laravel Caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Create storage symlink
php artisan storage:link --force

echo "✅ GusiiLyrics.com successfully deployed!"
