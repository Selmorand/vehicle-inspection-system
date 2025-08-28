@echo off
echo ================================================================
echo                AGGRESSIVE PROJECT CLEANUP
echo ================================================================
echo.
echo This will:
echo  - DELETE useless temporary and duplicate files
echo  - MOVE useful documentation to INFO folder  
echo  - Keep only ESSENTIAL files in root directory
echo.
echo ================================================================
echo                    ⚠️  WARNING  ⚠️
echo ================================================================
echo.
echo This action is IRREVERSIBLE! 
echo Files marked for deletion will be PERMANENTLY removed.
echo.
echo BEFORE PROCEEDING:
echo 1. Make sure you have committed any important changes to Git
echo 2. Create a backup if you're unsure about any files
echo.
set /p confirm="Type 'CLEANUP' to proceed or anything else to abort: "
if not "%confirm%"=="CLEANUP" (
    echo.
    echo Cleanup aborted. Smart move being cautious!
    pause
    exit /b
)

echo.
echo Starting aggressive cleanup...
echo.

REM Create INFO directory if it doesn't exist
if not exist "INFO" mkdir INFO

echo [1/6] Deleting useless temporary files...
REM Delete temporary/test files
if exist "nul" del "nul" >nul 2>&1
if exist "cookies.txt" del "cookies.txt" >nul 2>&1
if exist "laravel.log" del "laravel.log" >nul 2>&1
if exist "no_results.html" del "no_results.html" >nul 2>&1
if exist "search_result.html" del "search_result.html" >nul 2>&1
if exist "simple-image-test.html" del "simple-image-test.html" >nul 2>&1
if exist "simple-test.html" del "simple-test.html" >nul 2>&1
if exist "test_engine_submit.html" del "test_engine_submit.html" >nul 2>&1
if exist "GITERR.txt" del "GITERR.txt" >nul 2>&1
if exist "goodies.txt" del "goodies.txt" >nul 2>&1
if exist "staging-download.txt" del "staging-download.txt" >nul 2>&1
if exist "ssh.txt" del "ssh.txt" >nul 2>&1
if exist "interior 1024.png" del "interior 1024.png" >nul 2>&1
if exist "test_brake_pdf.pdf" del "test_brake_pdf.pdf" >nul 2>&1
if exist "interior-assesment-data.json" del "interior-assesment-data.json" >nul 2>&1
if exist "panelImages.csv" del "panelImages.csv" >nul 2>&1
if exist "panelImages.xlsx" del "panelImages.xlsx" >nul 2>&1
if exist "panelImages2.csv" del "panelImages2.csv" >nul 2>&1
if exist "interior-panels.csv" del "interior-panels.csv" >nul 2>&1

echo [2/6] Removing useless directories...
REM Delete useless folders
if exist "Ftemp" rmdir /s /q "Ftemp" >nul 2>&1
if exist "deploy-temp" rmdir /s /q "deploy-temp" >nul 2>&1
if exist "deployment" rmdir /s /q "deployment" >nul 2>&1
if exist "staging-deployment" rmdir /s /q "staging-deployment" >nul 2>&1
if exist "breakdown" rmdir /s /q "breakdown" >nul 2>&1
if exist "patches" rmdir /s /q "patches" >nul 2>&1
if exist "sc" rmdir /s /q "sc" >nul 2>&1

echo [3/6] Deleting old archives and duplicate files...
REM Delete old archives
if exist "alpha-staging-deployment.tar.gz" del "alpha-staging-deployment.tar.gz" >nul 2>&1
if exist "deployment.zip" del "deployment.zip" >nul 2>&1
if exist "staging-deploy.zip" del "staging-deploy.zip" >nul 2>&1
if exist "vendor.tar.gz" del "vendor.tar.gz" >nul 2>&1

REM Delete duplicate SQL dumps (keep vehicle_inspection_clean.sql)
if exist "staging-database-complete-mysql.sql" del "staging-database-complete-mysql.sql" >nul 2>&1
if exist "staging-database-complete.sql" del "staging-database-complete.sql" >nul 2>&1
if exist "staging-database-mysql.sql" del "staging-database-mysql.sql" >nul 2>&1
if exist "staging-schema.sql" del "staging-schema.sql" >nul 2>&1
if exist "production_new_changes.sql" del "production_new_changes.sql" >nul 2>&1

REM Delete SSH keys (can regenerate if needed)
if exist "staging_deploy_key" del "staging_deploy_key" >nul 2>&1
if exist "staging_deploy_key.pub" del "staging_deploy_key.pub" >nul 2>&1

echo [4/6] Removing duplicate deployment scripts...
REM Delete duplicate deployment scripts (keep backup_production.sh, quick_deploy_production.sh, staging_update.bat)
if exist "auto_deploy.bat" del "auto_deploy.bat" >nul 2>&1
if exist "debug_staging.bat" del "debug_staging.bat" >nul 2>&1
if exist "deploy-staging.bat" del "deploy-staging.bat" >nul 2>&1
if exist "deploy-staging.sh" del "deploy-staging.sh" >nul 2>&1
if exist "deploy-to-staging.sh" del "deploy-to-staging.sh" >nul 2>&1
if exist "deploy.exp" del "deploy.exp" >nul 2>&1
if exist "deploy_commands.txt" del "deploy_commands.txt" >nul 2>&1
if exist "deploy_staging.py" del "deploy_staging.py" >nul 2>&1
if exist "deploy_staging.sh" del "deploy_staging.sh" >nul 2>&1
if exist "deploy_to_staging.bat" del "deploy_to_staging.bat" >nul 2>&1
if exist "production_deployment.sh" del "production_deployment.sh" >nul 2>&1
if exist "manual-staging-deploy.bat" del "manual-staging-deploy.bat" >nul 2>&1
if exist "prepare-deployment.bat" del "prepare-deployment.bat" >nul 2>&1
if exist "staging_health_check.sh" del "staging_health_check.sh" >nul 2>&1
if exist "test-staging-connection.sh" del "test-staging-connection.sh" >nul 2>&1

echo [5/6] Removing one-time utility scripts...
REM Delete one-time PHP utilities (likely already used)
if exist "create-tables.php" del "create-tables.php" >nul 2>&1
if exist "export-all-tables.php" del "export-all-tables.php" >nul 2>&1
if exist "export-complete-mysql.php" del "export-complete-mysql.php" >nul 2>&1
if exist "export-mysql-format.php" del "export-mysql-format.php" >nul 2>&1
if exist "fix_production_migrations.php" del "fix_production_migrations.php" >nul 2>&1
if exist "generate-key.php" del "generate-key.php" >nul 2>&1
if exist "index-hosting-template.php" del "index-hosting-template.php" >nul 2>&1
if exist "install-composer.php" del "install-composer.php" >nul 2>&1
if exist "run-migrations.php" del "run-migrations.php" >nul 2>&1
if exist "optimize-images.bat" del "optimize-images.bat" >nul 2>&1

echo [6/6] Moving remaining documentation to INFO folder...
REM Move documentation files to INFO (except essential ones)
if exist "CHANGELOG.md" move "CHANGELOG.md" "INFO\" >nul 2>&1
if exist "CPANEL-DEPLOYMENT.md" move "CPANEL-DEPLOYMENT.md" "INFO\" >nul 2>&1
if exist "DEPLOYMENT_GUIDE.md" move "DEPLOYMENT_GUIDE.md" "INFO\" >nul 2>&1
if exist "GITHUB-SETUP.md" move "GITHUB-SETUP.md" "INFO\" >nul 2>&1
if exist "INSPECTION_CARDS_USAGE.md" move "INSPECTION_CARDS_USAGE.md" "INFO\" >nul 2>&1
if exist "PANEL_CARD_PATTERN.md" move "PANEL_CARD_PATTERN.md" "INFO\" >nul 2>&1
if exist "REPORT.md" move "REPORT.md" "INFO\" >nul 2>&1
if exist "STAGING-DEPLOY.md" move "STAGING-DEPLOY.md" "INFO\" >nul 2>&1
if exist "STAGING_DEPLOYMENT_INSTRUCTIONS.md" move "STAGING_DEPLOYMENT_INSTRUCTIONS.md" "INFO\" >nul 2>&1
if exist "STAGING_READY.md" move "STAGING_READY.md" "INFO\" >nul 2>&1
if exist "newPrompt.md" move "newPrompt.md" "INFO\" >nul 2>&1
if exist "procedure.md" move "procedure.md" "INFO\" >nul 2>&1
if exist "staging_deployment_checklist.md" move "staging_deployment_checklist.md" "INFO\" >nul 2>&1
if exist "AI vehicle inspection report.xlsx" move "AI vehicle inspection report.xlsx" "INFO\" >nul 2>&1

REM Move other miscellaneous files
if exist "docs" move "docs" "INFO\" >nul 2>&1
if exist "tools" move "tools" "INFO\" >nul 2>&1

echo.
echo ================================================================
echo                    CLEANUP COMPLETED!
echo ================================================================
echo.
echo SUMMARY:
echo - Deleted 50+ useless files and folders
echo - Moved documentation to INFO folder
echo - Root directory is now clean and professional
echo.
echo REMAINING IN ROOT:
echo ✓ Essential Laravel files (artisan, composer.json, etc.)
echo ✓ Core application folders (app/, public/, resources/, etc.)
echo ✓ CLAUDE.md (project instructions)
echo ✓ PRODUCTION_DEPLOYMENT_GUIDE.md (deployment guide)
echo ✓ README.md (project documentation)
echo ✓ backup_production.sh (production backup script)
echo ✓ quick_deploy_production.sh (production deployment)
echo ✓ staging_update.bat (staging deployment)
echo ✓ vehicle_inspection_clean.sql (database backup)
echo ✓ INFO folder (containing moved documentation)
echo.
echo Your project is now CLEAN and PROFESSIONAL! 🎉
echo.
pause