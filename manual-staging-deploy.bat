@echo off
echo ==========================================
echo Manual Staging Deployment Script
echo ==========================================
echo.
echo This script will help you manually deploy to staging
echo when GitHub Actions is not working properly.
echo.
pause

echo.
echo Step 1: Installing Composer dependencies...
call composer install --no-dev --optimize-autoloader --no-interaction
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)

echo.
echo Step 2: Creating deployment directory...
if exist deployment rmdir /s /q deployment
mkdir deployment

echo.
echo Step 3: Copying Laravel files...
xcopy /s /e /y app deployment\app\
xcopy /s /e /y bootstrap deployment\bootstrap\
xcopy /s /e /y config deployment\config\
xcopy /s /e /y database deployment\database\
xcopy /s /e /y resources deployment\resources\
xcopy /s /e /y routes deployment\routes\
xcopy /s /e /y storage deployment\storage\
xcopy /s /e /y vendor deployment\vendor\

echo.
echo Step 4: Copying root files...
copy /y artisan deployment\ >nul 2>&1
copy /y composer.json deployment\ >nul 2>&1
copy /y composer.lock deployment\ >nul 2>&1

echo.
echo Step 5: Copying public files to deployment root...
xcopy /s /e /y public\* deployment\

echo.
echo Step 6: Creating empty public folder (Laravel structure)...
mkdir deployment\public >nul 2>&1

echo.
echo Step 7: Creating staging .env file...
(
echo APP_NAME="Vehicle Inspection System - Staging"
echo APP_ENV=staging
echo APP_KEY=base64:GENERATE_NEW_KEY_ON_STAGING
echo APP_DEBUG=false
echo APP_URL=https://alpha.selpro.co.za
echo.
echo LOG_CHANNEL=stack
echo LOG_DEPRECATIONS_CHANNEL=null
echo LOG_LEVEL=debug
echo.
echo DB_CONNECTION=mysql
echo DB_HOST=localhost
echo DB_PORT=3306
echo DB_DATABASE=alphatest
echo DB_USERNAME=alphatest
echo DB_PASSWORD=qz2rg4QZ@RG$
echo.
echo BROADCAST_DRIVER=log
echo CACHE_DRIVER=file
echo FILESYSTEM_DRIVER=local
echo QUEUE_CONNECTION=sync
echo SESSION_DRIVER=file
echo SESSION_LIFETIME=120
echo.
echo MAIL_MAILER=smtp
echo MAIL_HOST=mailhog
echo MAIL_PORT=1025
echo MAIL_USERNAME=null
echo MAIL_PASSWORD=null
echo MAIL_ENCRYPTION=null
echo MAIL_FROM_ADDRESS=null
echo MAIL_FROM_NAME="${APP_NAME}"
) > deployment\.env

echo.
echo Step 8: Updating index.php for shared hosting...
powershell -Command "(Get-Content deployment\index.php) -replace '__DIR__\.''/../vendor/autoload\.php''', '__DIR__.''/vendor/autoload.php''' | Set-Content deployment\index.php"
powershell -Command "(Get-Content deployment\index.php) -replace '__DIR__\.''/../bootstrap/app\.php''', '__DIR__.''/bootstrap/app.php''' | Set-Content deployment\index.php"

echo.
echo ==========================================
echo Deployment files prepared successfully!
echo ==========================================
echo.
echo The 'deployment' folder now contains all files ready for staging.
echo.
echo NEXT STEPS:
echo 1. Upload the contents of the 'deployment' folder to:
echo    /public_html/alpha.selpro.co.za/
echo.
echo 2. Set folder permissions on the staging server:
echo    - storage/ folder: 755
echo    - bootstrap/cache/ folder: 755
echo.
echo 3. Generate a new APP_KEY on staging by running:
echo    php artisan key:generate
echo.
echo 4. Run database migrations:
echo    php artisan migrate
echo.
echo 5. Test the deployment:
echo    https://alpha.selpro.co.za/staging-test.php
echo.
pause