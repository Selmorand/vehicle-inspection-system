@echo off
echo ===============================================
echo   Staging Server Update Script
echo   Server: alphainspections.co.za
echo   Port: 22000
echo ===============================================
echo.
echo Please use the following credentials when prompted:
echo Username: alphains
echo Password: Suq8h0QkFB[+18
echo.
echo Commands to run after connecting:
echo 1. cd /home/alphains/staging
echo 2. git pull origin staging
echo 3. php artisan config:clear
echo 4. php artisan cache:clear
echo 5. php artisan view:clear
echo.
echo Opening SSH connection...
echo.
ssh -p 22000 alphains@alphainspections.co.za