#!/bin/bash

echo "🚀 Starting production deployment..."

# Set proper permissions
echo "📝 Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
chmod 644 .env

# Install/update dependencies (only if composer.json changed)
if [ -f composer.json ]; then
    echo "📦 Installing dependencies..."
    if [ ! -f composer.phar ]; then
        curl -sS https://getcomposer.org/installer | php
    fi
    php composer.phar install --no-dev --optimize-autoloader --no-interaction
fi

# Generate application key if not exists
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "🔐 Generating application key..."
    php artisan key:generate --force
fi

# Run Laravel optimizations
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations (production - be careful!)
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Create storage symlink if it doesn't exist
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage symlink..."
    php artisan storage:link
fi

# Clear and rebuild caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "🔄 Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set final permissions
echo "🔒 Setting final permissions..."
chmod -R 775 storage bootstrap/cache
chown -R alphains:alphains storage bootstrap/cache

echo "✅ Production deployment completed!"