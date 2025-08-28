#!/bin/bash
# QUICK PRODUCTION DEPLOYMENT SCRIPT
# ⚠️ WARNING: Only use AFTER creating backup and testing on staging!

echo "================================================"
echo "   PRODUCTION DEPLOYMENT - ALPHA INSPECTIONS   "
echo "================================================"
echo ""
echo "⚠️  SAFETY CHECKLIST:"
echo "□ Have you tested these changes on staging?"
echo "□ Have you created a full backup?"
echo "□ Are you deploying during low-traffic hours?"
echo "□ Do you have a rollback plan ready?"
echo ""
read -p "Type 'DEPLOY' to continue or anything else to abort: " confirmation

if [ "$confirmation" != "DEPLOY" ]; then
    echo "Deployment aborted. Good call being cautious!"
    exit 0
fi

# Production directory
cd /home/alphains/public_html/alphainspections.co.za

echo "Starting production deployment..."

# 1. Enable maintenance mode
echo "Enabling maintenance mode..."
php artisan down --message="System maintenance in progress. We'll be back in 5 minutes." --retry=300

# 2. Git pull
echo "Pulling latest code..."
git fetch origin
git checkout production  # or main, depending on your setup
git pull origin production

# 3. Install dependencies if needed
if [ -f "composer.lock" ]; then
    echo "Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# 4. Run migrations (ONLY safe ones)
echo "Running database migrations..."
php artisan migrate --force

# 5. Clear all caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 6. Rebuild caches
echo "Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Set permissions
echo "Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/logs/*.log

# 8. Quick health check
echo "Running health check..."
php artisan tinker --no-interaction <<EOF
echo "Inspections count: " . App\Models\Inspection::count();
echo "\nLast inspection date: " . App\Models\Inspection::latest()->first()->created_at;
EOF

# 9. Disable maintenance mode
echo "Bringing site back online..."
php artisan up

echo ""
echo "================================================"
echo "         DEPLOYMENT COMPLETE!                  "
echo "================================================"
echo ""
echo "IMMEDIATE ACTIONS REQUIRED:"
echo "1. Visit https://alphainspections.co.za and test login"
echo "2. Check that existing reports are accessible"
echo "3. Monitor logs: tail -f storage/logs/laravel.log"
echo "4. If issues occur, run rollback immediately!"
echo ""
echo "Deployment finished at: $(date)"