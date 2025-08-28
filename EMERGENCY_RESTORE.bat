@echo off
echo ================================================================
echo                    EMERGENCY RESTORE
echo ================================================================
echo.
echo This will attempt to restore functionality by:
echo 1. Clearing all Laravel caches
echo 2. Regenerating autoload files
echo 3. Setting proper permissions
echo 4. Creating any missing directories
echo.
pause

echo Clearing Laravel caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo.
echo Regenerating composer autoload...
composer dump-autoload

echo.
echo Creating missing directories...
if not exist "storage\logs" mkdir "storage\logs"
if not exist "storage\framework\cache" mkdir "storage\framework\cache"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "bootstrap\cache" mkdir "bootstrap\cache"

echo.
echo Setting file permissions (where possible on Windows)...
attrib -r "storage\*" /s
attrib -r "bootstrap\cache\*" /s

echo.
echo Checking key Laravel files...
if exist "artisan" echo ✓ artisan exists
if exist "composer.json" echo ✓ composer.json exists
if exist ".env" echo ✓ .env exists
if exist "public\index.php" echo ✓ public/index.php exists

echo.
echo Testing Laravel configuration...
php artisan --version

echo.
echo ================================================================
echo                 RESTORATION COMPLETE
echo ================================================================
echo.
echo Try accessing your site now. If it still doesn't work,
echo the issue might be with:
echo 1. XAMPP not running
echo 2. Wrong URL (try http://localhost/vehicle-inspection)
echo 3. Database connection issues
echo 4. .env file configuration
echo.
pause