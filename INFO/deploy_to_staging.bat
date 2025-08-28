@echo off
REM Windows batch script to deploy to staging via SSH
REM Replace with your actual SSH details

echo ====================================
echo   DEPLOYING TO STAGING VIA SSH
echo ====================================

set SSH_HOST=staging.alphainspections.co.za
set SSH_USER=alphains
set PROJECT_PATH=/home/alphains/public_html/staging.alphainspections.co.za

echo.
echo Connecting to %SSH_HOST% as %SSH_USER%...
echo.

REM Single SSH command that does everything
ssh %SSH_USER%@%SSH_HOST% "
    echo 'Starting deployment...'
    cd %PROJECT_PATH%
    
    echo '1. Pulling latest code...'
    git pull origin staging
    
    echo '2. Clearing caches...'
    php artisan optimize:clear
    
    echo '3. Updating dependencies...'
    composer dump-autoload --optimize
    
    echo '4. Rebuilding caches...'
    php artisan config:cache
    php artisan route:cache
    
    echo '5. Fixing permissions...'
    chmod -R 775 storage bootstrap/cache
    mkdir -p storage/app/public/reports
    chmod -R 775 storage/app/public/reports
    
    echo '6. Testing site...'
    curl -I https://staging.alphainspections.co.za | head -1
    
    echo 'Deployment complete!'
"

echo.
echo ====================================
echo   DEPLOYMENT FINISHED
echo ====================================
pause