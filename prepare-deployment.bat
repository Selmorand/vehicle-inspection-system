@echo off
echo ========================================
echo Vehicle Inspection Deployment Preparation
echo ========================================
echo.

REM Create deployment folder
echo Creating deployment folder...
if not exist "deployment" mkdir deployment

REM Copy essential files
echo Copying application files...
xcopy /E /I /Y app deployment\app
xcopy /E /I /Y bootstrap deployment\bootstrap
xcopy /E /I /Y config deployment\config
xcopy /E /I /Y database deployment\database
xcopy /E /I /Y public deployment\public
xcopy /E /I /Y resources deployment\resources
xcopy /E /I /Y routes deployment\routes
xcopy /E /I /Y vendor deployment\vendor

REM Copy root files
copy /Y .htaccess deployment\ 2>NUL
copy /Y artisan deployment\
copy /Y composer.json deployment\
copy /Y composer.lock deployment\
copy /Y package.json deployment\ 2>NUL
copy /Y phpunit.xml deployment\ 2>NUL
copy /Y server.php deployment\ 2>NUL

REM Create storage structure
echo Creating storage directories...
mkdir deployment\storage\app\public 2>NUL
mkdir deployment\storage\framework\cache 2>NUL
mkdir deployment\storage\framework\sessions 2>NUL
mkdir deployment\storage\framework\testing 2>NUL
mkdir deployment\storage\framework\views 2>NUL
mkdir deployment\storage\logs 2>NUL

REM Create .env.production template
echo Creating production environment template...
echo APP_NAME="ALPHA Vehicle Inspection" > deployment\.env.production
echo APP_ENV=production >> deployment\.env.production
echo APP_KEY= >> deployment\.env.production
echo APP_DEBUG=false >> deployment\.env.production
echo APP_URL=https://yourdomain.co.za >> deployment\.env.production
echo. >> deployment\.env.production
echo LOG_CHANNEL=stack >> deployment\.env.production
echo LOG_LEVEL=error >> deployment\.env.production
echo. >> deployment\.env.production
echo DB_CONNECTION=mysql >> deployment\.env.production
echo DB_HOST=localhost >> deployment\.env.production
echo DB_PORT=3306 >> deployment\.env.production
echo DB_DATABASE=your_database_name >> deployment\.env.production
echo DB_USERNAME=your_database_user >> deployment\.env.production
echo DB_PASSWORD=your_database_password >> deployment\.env.production
echo. >> deployment\.env.production
echo BROADCAST_DRIVER=log >> deployment\.env.production
echo CACHE_DRIVER=file >> deployment\.env.production
echo FILESYSTEM_DISK=local >> deployment\.env.production
echo QUEUE_CONNECTION=sync >> deployment\.env.production
echo SESSION_DRIVER=file >> deployment\.env.production
echo SESSION_LIFETIME=120 >> deployment\.env.production

echo.
echo ========================================
echo Deployment preparation complete!
echo ========================================
echo.
echo Next steps:
echo 1. Update .env.production with your server details
echo 2. Export your database from phpMyAdmin
echo 3. Create a zip of the 'deployment' folder
echo 4. Upload to your Domains.co.za hosting
echo.
pause