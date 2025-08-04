@echo off
echo ========================================
echo  Laravel Staging Deployment Script
echo ========================================
echo.

REM Clean previous deployment
if exist staging-deployment (
    echo Cleaning previous deployment...
    rmdir /s /q staging-deployment
)

REM Create deployment directory
echo Creating deployment package...
mkdir staging-deployment

REM Copy Laravel framework files (but not public contents yet)
xcopy /s /e /i app staging-deployment\app
xcopy /s /e /i bootstrap staging-deployment\bootstrap
xcopy /s /e /i config staging-deployment\config
xcopy /s /e /i database staging-deployment\database
xcopy /s /e /i resources staging-deployment\resources
xcopy /s /e /i routes staging-deployment\routes
xcopy /s /e /i storage staging-deployment\storage
xcopy /s /e /i vendor staging-deployment\vendor

REM Copy root files
copy artisan staging-deployment\artisan 2>nul
copy composer.json staging-deployment\composer.json 2>nul
copy composer.lock staging-deployment\composer.lock 2>nul
copy package.json staging-deployment\package.json 2>nul

REM Copy public folder contents to root (for hosting compatibility)
echo Restructuring for shared hosting...
xcopy /s /e public\* staging-deployment\

REM Create empty public folder (to maintain Laravel structure)
mkdir staging-deployment\public

REM Create staging environment file
if exist .env.staging (
    copy .env.staging staging-deployment\.env
    echo Staging environment file copied
) else (
    copy .env.example staging-deployment\.env
    echo WARNING: .env.staging not found, using .env.example
    echo Please configure database settings manually
)

REM Modify index.php for hosting structure
echo Updating index.php for hosting structure...
powershell -Command "(Get-Content staging-deployment\index.php) -replace '__DIR__\.\'/\.\./vendor/autoload\.php', '__DIR__.\'/vendor/autoload.php' | Set-Content staging-deployment\index.php"
powershell -Command "(Get-Content staging-deployment\index.php) -replace '__DIR__\.\'/\.\./bootstrap/app\.php', '__DIR__.\'/bootstrap/app.php' | Set-Content staging-deployment\index.php"

REM Create zip file for upload
echo Creating zip file for upload...
powershell -Command "Compress-Archive -Path staging-deployment\* -DestinationPath staging-deploy.zip -Force"

echo.
echo ========================================
echo  Deployment Package Created!
echo ========================================
echo.
echo Next steps:
echo 1. Upload staging-deploy.zip to your hosting control panel
echo 2. Extract to /public_html/alpha.selpro.co.za/
echo 3. Set storage folder permissions to 755
echo 4. Set bootstrap/cache folder permissions to 755
echo 5. Test at https://alpha.selpro.co.za
echo.
echo Files ready in: staging-deploy.zip
echo ========================================
pause