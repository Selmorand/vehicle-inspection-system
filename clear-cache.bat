@echo off
echo Clearing all Laravel caches...

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo.
echo Rebuilding caches...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo.
echo Cache cleared successfully!
pause