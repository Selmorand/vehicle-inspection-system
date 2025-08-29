#!/bin/bash

# Post-Deployment Cache Clear Script
# Run this after pulling changes on staging/production

echo "🧹 Starting comprehensive cache clear..."

# 1. Clear all Laravel caches
echo "📦 Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 2. Clear compiled files
echo "🔧 Clearing compiled files..."
php artisan clear-compiled
php artisan optimize:clear

# 3. Clear opcache if available
echo "⚡ Clearing OPcache..."
if php -r "exit(function_exists('opcache_reset') ? 0 : 1);" ; then
    php -r "opcache_reset();"
    echo "✅ OPcache cleared"
else
    echo "⚠️  OPcache not available"
fi

# 4. Rebuild optimized files
echo "🔨 Rebuilding optimized files..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Run any pending migrations
echo "🗄️ Checking for pending migrations..."
php artisan migrate --force

# 6. Restart queue workers if any
echo "🔄 Restarting queue workers..."
php artisan queue:restart 2>/dev/null || echo "⚠️  No queue workers running"

echo "✅ Cache clear complete!"
echo ""
echo "📊 Current status:"
php artisan about --only=environment