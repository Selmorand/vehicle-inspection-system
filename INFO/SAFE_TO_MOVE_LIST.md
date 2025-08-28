# FILES SAFE TO MOVE TO INFO FOLDER

## ✅ DOCUMENTATION FILES (Safe to move)
- AI vehicle inspection report.xlsx
- CHANGELOG.md
- CPANEL-DEPLOYMENT.md
- DEPLOYMENT_GUIDE.md
- GITHUB-SETUP.md
- INSPECTION_CARDS_USAGE.md
- PANEL_CARD_PATTERN.md
- PRODUCTION_DEPLOYMENT_GUIDE.md
- README.md
- REPORT.md
- STAGING-DEPLOY.md
- STAGING_DEPLOYMENT_INSTRUCTIONS.md
- STAGING_READY.md
- newPrompt.md
- procedure.md
- staging_deployment_checklist.md

## ✅ BACKUP/ARCHIVE FILES (Safe to move)
- alpha-staging-deployment.tar.gz
- deployment.zip
- staging-deploy.zip
- vendor.tar.gz
- staging-database-complete-mysql.sql
- staging-database-complete.sql
- staging-database-mysql.sql
- vehicle_inspection_clean.sql
- staging-schema.sql
- production_new_changes.sql

## ✅ DEPLOYMENT SCRIPTS (Safe to move - but create backup copies first)
- auto_deploy.bat
- backup_production.sh
- quick_deploy_production.sh
- debug_staging.bat
- deploy-staging.bat
- deploy-staging.sh
- deploy-to-staging.sh
- deploy.exp
- deploy_commands.txt
- deploy_staging.py
- deploy_staging.sh
- deploy_to_staging.bat
- production_deployment.sh
- manual-staging-deploy.bat
- prepare-deployment.bat
- staging_health_check.sh
- staging_update.bat
- test-staging-connection.sh

## ✅ DEVELOPMENT FILES (Safe to move)
- cookies.txt
- goodies.txt
- GITERR.txt
- laravel.log
- no_results.html
- search_result.html
- ssh.txt
- staging-download.txt
- simple-image-test.html
- simple-test.html
- test_brake_pdf.pdf
- test_engine_submit.html
- interior-assesment-data.json
- panelImages.csv
- panelImages.xlsx
- panelImages2.csv
- interior 1024.png

## ✅ TEMPORARY/BUILD FOLDERS (Safe to move entire folders)
- Ftemp\
- deploy-temp\
- deployment\
- staging-deployment\
- breakdown\ (appears to be old image assets)
- patches\
- docs\
- sc\ (screenshots folder)

## ✅ SSH KEYS (Safe to move but keep backup)
- staging_deploy_key
- staging_deploy_key.pub

## ✅ EXPORT/UTILITY SCRIPTS (Safe to move)
- create-tables.php
- export-all-tables.php
- export-complete-mysql.php
- export-mysql-format.php
- fix_production_migrations.php
- generate-key.php
- index-hosting-template.php
- install-composer.php
- optimize-images.bat
- run-migrations.php

---

## ❌ CRITICAL FILES - NEVER MOVE (Required for system functionality)

### Core Laravel Files
- artisan
- composer.json
- composer.lock
- package.json
- package-lock.json
- phpunit.xml
- vite.config.js
- .env (not visible but critical)
- .gitignore (not visible but important)

### Application Code
- app\
- bootstrap\
- config\
- database\
- public\
- resources\
- routes\
- storage\
- tests\
- vendor\

### Node Modules
- node_modules\ (large but required for build processes)

### Project Instructions
- CLAUDE.md (This is your project instructions file - keep in root!)

---

## 📋 RECOMMENDED ACTION PLAN

### Step 1: Create INFO folder
```bash
mkdir INFO
```

### Step 2: Move documentation first
```bash
# Move all .md files except CLAUDE.md
move *.md INFO\ (but exclude CLAUDE.md)
move *.xlsx INFO\
move *.txt INFO\ (except critical ones)
```

### Step 3: Move archive/backup files
```bash
move *.tar.gz INFO\
move *.zip INFO\
move *.sql INFO\
```

### Step 4: Move deployment scripts (keep copies of important ones)
```bash
move *deploy*.* INFO\
move *staging*.* INFO\
move *.bat INFO\ (deployment related)
move *.sh INFO\ (deployment related)
```

### Step 5: Move temporary folders
```bash
move Ftemp INFO\
move deploy-temp INFO\
move deployment INFO\
move staging-deployment INFO\
move breakdown INFO\
move patches INFO\
move docs INFO\
move sc INFO\
```

This will clean up approximately 70% of the root directory clutter while preserving all system functionality!