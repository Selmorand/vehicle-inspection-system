@echo off
echo ===============================================
echo    AUTOMATED STAGING DEPLOYMENT
echo ===============================================
echo.
echo This script will deploy to staging server.
echo.
echo Server: alphainspections.co.za
echo Port: 22000
echo User: alphains
echo Password: Suq8h0QkFB[+18
echo.
echo ===============================================
echo.
echo Copy and paste these commands after login:
echo.
echo cd /home/alphains/staging ^&^& git pull origin staging ^&^& php artisan config:clear ^&^& php artisan cache:clear ^&^& php artisan view:clear ^&^& php artisan route:clear ^&^& echo "DEPLOYMENT COMPLETE!"
echo.
echo ===============================================
echo.
echo Connecting to server...
echo.
ssh -p 22000 alphains@alphainspections.co.za