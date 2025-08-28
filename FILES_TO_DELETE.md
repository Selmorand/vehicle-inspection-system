# FILES TO DELETE COMPLETELY

## 🗑️ SAFE TO DELETE - NO VALUE

### Temporary/Cache Files
- `nul` - Empty/null file
- `cookies.txt` - Browser cookies (temporary)
- `laravel.log` - Old log file (Laravel creates new ones)
- `no_results.html` - Test file
- `search_result.html` - Test output
- `simple-image-test.html` - Development test
- `simple-test.html` - Development test
- `test_engine_submit.html` - Development test

### Test/Debug Files  
- `GITERR.txt` - Git error log (temporary)
- `goodies.txt` - Random notes
- `staging-download.txt` - Temporary notes
- `ssh.txt` - Duplicate SSH info

### Development Images/Assets (No longer needed)
- `interior 1024.png` - Seems like a test image
- `test_brake_pdf.pdf` - Test PDF file

### CSV Files (Likely outdated data)
- `interior-assesment-data.json` - Old test data
- `panelImages.csv` - Probably outdated
- `panelImages.xlsx` - Excel version of CSV
- `panelImages2.csv` - Another version
- `interior-panels.csv` - Old panel data

### Entire Useless Folders (DELETE COMPLETELY)
- `Ftemp\` - Temporary folder
- `Ftempvehicle_inspection_clean.sql` - Seems like a temp file path
- `deploy-temp\` - Deployment test folder (outdated)
- `deployment\` - Old deployment attempt
- `staging-deployment\` - Another old deployment folder
- `breakdown\` - Old image breakdown folder (images now in public/images)
- `patches\` - Git patches (likely applied already)
- `sc\` - Screenshots folder (just contains notes and test images)

### Archive Files (Keep only latest, delete rest)
- `alpha-staging-deployment.tar.gz` - Old deployment
- `deployment.zip` - Old deployment  
- `staging-deploy.zip` - Old deployment
- `vendor.tar.gz` - Vendor backup (can regenerate with composer)

### Old SQL Dumps (Keep only 1-2 latest)
- `staging-database-complete-mysql.sql`
- `staging-database-complete.sql` 
- `staging-database-mysql.sql`
- `vehicle_inspection_clean.sql`
- `staging-schema.sql`
- `production_new_changes.sql`

### Old Deployment Scripts (Many duplicates)
DELETE MOST, KEEP ONLY:
- `backup_production.sh` (KEEP)
- `quick_deploy_production.sh` (KEEP)
- `staging_update.bat` (KEEP)

DELETE THESE DUPLICATES:
- `auto_deploy.bat`
- `debug_staging.bat`
- `deploy-staging.bat`
- `deploy-staging.sh`
- `deploy-to-staging.sh`
- `deploy.exp`
- `deploy_commands.txt`
- `deploy_staging.py`
- `deploy_staging.sh`
- `deploy_to_staging.bat`
- `production_deployment.sh`
- `manual-staging-deploy.bat`
- `prepare-deployment.bat`
- `staging_health_check.sh`
- `test-staging-connection.sh`

### PHP Utility Scripts (One-time use, likely done)
- `create-tables.php` - Database setup (likely done)
- `export-all-tables.php` - Export utility
- `export-complete-mysql.php` - Export utility
- `export-mysql-format.php` - Export utility
- `fix_production_migrations.php` - Migration fix (likely applied)
- `generate-key.php` - Key generation (done)
- `index-hosting-template.php` - Template (not needed)
- `install-composer.php` - Install script (done)
- `run-migrations.php` - Migration runner (done)

### SSH Keys (If not using)
- `staging_deploy_key` - SSH key for deployment
- `staging_deploy_key.pub` - Public key

### Documentation Overload (Keep 2-3 key ones)
KEEP ONLY:
- `CLAUDE.md` (ESSENTIAL)
- `PRODUCTION_DEPLOYMENT_GUIDE.md` (ESSENTIAL)
- `README.md` (ESSENTIAL)

DELETE THESE DUPLICATE DOCS:
- `CHANGELOG.md`
- `CPANEL-DEPLOYMENT.md`
- `DEPLOYMENT_GUIDE.md`
- `GITHUB-SETUP.md`
- `INSPECTION_CARDS_USAGE.md`
- `PANEL_CARD_PATTERN.md`
- `REPORT.md`
- `STAGING-DEPLOY.md`
- `STAGING_DEPLOYMENT_INSTRUCTIONS.md`
- `STAGING_READY.md`
- `newPrompt.md`
- `procedure.md`
- `staging_deployment_checklist.md`
- `AI vehicle inspection report.xlsx`

---

## 🧹 AGGRESSIVE CLEANUP COMMANDS

### Step 1: Delete Useless Files
```bash
# Delete temporary/test files
del nul cookies.txt laravel.log no_results.html search_result.html
del simple-image-test.html simple-test.html test_engine_submit.html
del GITERR.txt goodies.txt staging-download.txt ssh.txt
del "interior 1024.png" test_brake_pdf.pdf
del interior-assesment-data.json panelImages.csv panelImages.xlsx panelImages2.csv

# Delete useless folders
rmdir /s Ftemp
rmdir /s deploy-temp  
rmdir /s deployment
rmdir /s staging-deployment
rmdir /s breakdown
rmdir /s patches
rmdir /s sc

# Delete old archives
del alpha-staging-deployment.tar.gz deployment.zip staging-deploy.zip vendor.tar.gz

# Delete duplicate SQL dumps (keep only 1)
del staging-database-complete-mysql.sql staging-database-complete.sql
del staging-schema.sql production_new_changes.sql

# Delete duplicate deployment scripts  
del auto_deploy.bat debug_staging.bat deploy-staging.bat deploy-staging.sh
del deploy-to-staging.sh deploy.exp deploy_commands.txt deploy_staging.py
del deploy_staging.sh deploy_to_staging.bat production_deployment.sh
del manual-staging-deploy.bat prepare-deployment.bat staging_health_check.sh
del test-staging-connection.sh

# Delete one-time PHP utilities
del create-tables.php export-all-tables.php export-complete-mysql.php
del export-mysql-format.php fix_production_migrations.php generate-key.php
del index-hosting-template.php install-composer.php run-migrations.php

# Delete SSH keys (if not needed)
del staging_deploy_key staging_deploy_key.pub
```

### Step 2: Keep Only Essential Docs
```bash
# Move docs to INFO, then bring back essentials
mkdir INFO
move *.md INFO\
move *.xlsx INFO\

# Bring back only essentials
copy INFO\CLAUDE.md .
copy INFO\PRODUCTION_DEPLOYMENT_GUIDE.md .
copy INFO\README.md .
```

### Step 3: Final Result
Your root directory should only contain:
- **CLAUDE.md** (project instructions)
- **PRODUCTION_DEPLOYMENT_GUIDE.md** (deployment guide)  
- **README.md** (project readme)
- **backup_production.sh** (production backup)
- **quick_deploy_production.sh** (production deploy)
- **staging_update.bat** (staging deploy)
- **vehicle_inspection_clean.sql** (keep 1 DB backup)
- **Core Laravel files** (artisan, composer.json, etc.)
- **Core Laravel folders** (app/, public/, resources/, etc.)
- **INFO/** (everything else moved here)

This will reduce root directory from **100+ files** to about **15-20 essential files**!