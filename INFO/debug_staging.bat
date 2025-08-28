@echo off
REM Windows batch script to debug staging server issues via SSH

echo ====================================
echo   DEBUGGING STAGING SERVER VIA SSH
echo ====================================

set SSH_HOST=staging.alphainspections.co.za
set SSH_USER=alphains
set PROJECT_PATH=/home/alphains/public_html/staging.alphainspections.co.za

echo.
echo Connecting to %SSH_HOST% to debug...
echo.

REM SSH command for debugging
ssh %SSH_USER%@%SSH_HOST% "
    cd %PROJECT_PATH%
    
    echo '=== STAGING DEBUG REPORT ==='
    echo
    
    echo '1. Current directory:'
    pwd
    
    echo
    echo '2. Laravel logs (last 20 lines):'
    tail -20 storage/logs/laravel.log 2>/dev/null || echo 'No Laravel logs found'
    
    echo
    echo '3. PHP errors:'
    tail -10 /var/log/php_errors.log 2>/dev/null || echo 'No PHP error logs accessible'
    
    echo
    echo '4. Site HTTP status:'
    curl -I https://staging.alphainspections.co.za 2>/dev/null | head -1 || echo 'Site not responding'
    
    echo
    echo '5. Critical files check:'
    [ -f '.env' ] && echo '.env exists' || echo '.env MISSING!'
    [ -d 'vendor' ] && echo 'vendor directory exists' || echo 'vendor MISSING!'
    [ -d 'storage/logs' ] && echo 'logs directory exists' || echo 'logs directory MISSING!'
    
    echo
    echo '6. Permissions check:'
    ls -la storage/ | head -5
    
    echo
    echo '7. PHP version:'
    php -v | head -1
    
    echo
    echo '8. Composer status:'
    composer --version 2>/dev/null || echo 'Composer not accessible'
    
    echo
    echo '=== DEBUG COMPLETE ==='
"

pause