#!/bin/bash

# Vehicle Inspection System - Staging Deployment Script
echo "🚀 Starting staging deployment..."

# 1. Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 2. Set up environment
echo "⚙️ Setting up environment..."
cp .env.staging .env

# 3. Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# 4. Clear and cache configuration
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "💾 Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 6. Seed default users
echo "👤 Creating default users..."
php artisan db:seed --class=UserSeeder --force

# 6. Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# 7. Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

echo "✅ Staging deployment completed!"
echo "Don't forget to:"
echo "1. Update .env with your actual database credentials"
echo "2. Update APP_URL with your staging domain"
echo "3. Configure your web server to point to /public"