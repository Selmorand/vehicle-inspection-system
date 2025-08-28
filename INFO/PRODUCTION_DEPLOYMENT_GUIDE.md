# PRODUCTION DEPLOYMENT & BACKUP GUIDE
**⚠️ CRITICAL: READ ENTIRE DOCUMENT BEFORE ANY PRODUCTION DEPLOYMENT**

Last Updated: August 28, 2025
Server: alphainspections.co.za
SSH Port: 22000
Username: alphains
Password: Suq8h0QkFB[+18

---

## 🔴 PRODUCTION DEPLOYMENT CHECKLIST

### BEFORE YOU START - CRITICAL CHECKS
1. **NEVER deploy directly to production without testing on staging first**
2. **ALWAYS create a full backup before deployment (see Section 2)**
3. **NEVER run `php artisan migrate:fresh` or `migrate:reset` on production**
4. **NEVER delete or modify existing inspection reports**
5. **Schedule deployments during low-traffic hours (recommended: 2-5 AM SAST)**

### Step 1: Pre-Deployment Verification

```bash
# 1. First, verify changes work on staging
ssh -p 22000 alphains@alphainspections.co.za
cd public_html/staging.alphainspections.co.za
git status
git log --oneline -5

# 2. Test staging site thoroughly
# Visit: https://staging.alphainspections.co.za
# Test all critical functions:
# - Login
# - Create new inspection
# - View reports
# - Generate PDFs
```

### Step 2: Create Full Production Backup

```bash
# Connect to server
ssh -p 22000 alphains@alphainspections.co.za

# Navigate to production
cd public_html/alphainspections.co.za

# Create backup directory with timestamp
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p ~/backups/production_$BACKUP_DATE

# Backup database
php artisan db:backup --database=mysql --destination=~/backups/production_$BACKUP_DATE/database.sql

# OR use mysqldump directly
mysqldump -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] > ~/backups/production_$BACKUP_DATE/database.sql

# Backup all uploaded files and images
tar -czf ~/backups/production_$BACKUP_DATE/uploads.tar.gz storage/app/public/
tar -czf ~/backups/production_$BACKUP_DATE/public_uploads.tar.gz public/uploads/

# Backup current .env file
cp .env ~/backups/production_$BACKUP_DATE/.env.backup

# Backup entire application (optional but recommended)
tar --exclude='node_modules' --exclude='vendor' -czf ~/backups/production_$BACKUP_DATE/app_code.tar.gz .

# Verify backup was created
ls -lh ~/backups/production_$BACKUP_DATE/
```

### Step 3: Production Deployment Process

```bash
# 1. Put application in maintenance mode
php artisan down --message="System maintenance in progress. We'll be back shortly." --retry=60

# 2. Pull latest code from production branch
git fetch origin
git checkout production  # or 'main' depending on your branch
git pull origin production

# 3. Install dependencies (if composer.lock changed)
composer install --no-dev --optimize-autoloader

# 4. Run SAFE migrations only (never destructive ones)
php artisan migrate --force
# ⚠️ NEVER run migrate:fresh or migrate:reset

# 5. Clear and rebuild caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set correct permissions
chmod -R 755 storage bootstrap/cache
chmod -R 644 storage/logs/*.log

# 7. Verify application is working
php artisan tinker
# Run: App\Models\Inspection::count()
# This should return the number of inspections (not 0)
# Exit with: exit

# 8. Bring application back online
php artisan up

# 9. Test production site immediately
# Visit https://alphainspections.co.za
# Test login and view existing reports
```

### Step 4: Post-Deployment Verification

```bash
# Check error logs for any issues
tail -f storage/logs/laravel.log

# Verify no data was lost
php artisan tinker
>>> App\Models\Inspection::count()
>>> App\Models\InspectionImage::count()
>>> exit

# Monitor for 10-15 minutes for any errors
```

### Step 5: Rollback Procedure (If Something Goes Wrong)

```bash
# 1. Put site in maintenance mode immediately
php artisan down

# 2. Restore previous code
git log --oneline -10  # Find previous commit hash
git checkout [PREVIOUS_COMMIT_HASH]

# 3. Restore database if needed
mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] < ~/backups/production_$BACKUP_DATE/database.sql

# 4. Clear caches
php artisan config:clear
php artisan cache:clear

# 5. Bring site back up
php artisan up
```

---

## 💾 DATABASE BACKUP STRATEGIES

### Automated Daily Backups (RECOMMENDED)

Create a cron job for automatic daily backups:

```bash
# Edit crontab
crontab -e

# Add this line for daily backup at 2 AM
0 2 * * * cd /home/alphains/public_html/alphainspections.co.za && /usr/bin/php artisan backup:run >> /home/alphains/backup_logs.txt 2>&1

# Or use mysqldump directly
0 2 * * * mysqldump -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] | gzip > /home/alphains/backups/db_$(date +\%Y\%m\%d).sql.gz
```

### Manual Backup Script

Create `backup_production.sh`:

```bash
#!/bin/bash
# Production Backup Script

BACKUP_DIR="$HOME/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_PATH="$BACKUP_DIR/production_$TIMESTAMP"

# Create backup directory
mkdir -p $BACKUP_PATH

# Database credentials (update these)
DB_NAME="your_db_name"
DB_USER="your_db_user"
DB_PASS="your_db_password"

echo "Starting backup at $(date)"

# Backup database
echo "Backing up database..."
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_PATH/database.sql
gzip $BACKUP_PATH/database.sql

# Backup uploads
echo "Backing up uploaded files..."
cd /home/alphains/public_html/alphainspections.co.za
tar -czf $BACKUP_PATH/uploads.tar.gz storage/app/public/ public/uploads/

# Backup inspection reports (PDFs)
echo "Backing up inspection reports..."
tar -czf $BACKUP_PATH/reports.tar.gz storage/app/reports/

# Keep only last 30 days of backups
find $BACKUP_DIR -name "production_*" -mtime +30 -delete

echo "Backup completed at $(date)"
echo "Backup location: $BACKUP_PATH"
```

### Off-Site Backup (CRITICAL)

```bash
# 1. Download backups to local machine regularly
scp -P 22000 alphains@alphainspections.co.za:~/backups/production_*.tar.gz ./local_backups/

# 2. Or sync to cloud storage (example with rclone)
# First configure rclone with your cloud provider
rclone copy ~/backups remote:alphainspections-backups/
```

---

## 🔄 DATABASE RESTORE PROCEDURES

### Full Database Restore

```bash
# ⚠️ WARNING: This will replace entire database
# Only do this if you're certain!

# 1. Create backup of current (possibly corrupted) database
mysqldump -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] > ~/emergency_backup_$(date +%Y%m%d).sql

# 2. Restore from backup
gunzip < ~/backups/production_20250828/database.sql.gz | mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME]

# 3. Clear Laravel caches
cd /home/alphains/public_html/alphainspections.co.za
php artisan config:clear
php artisan cache:clear
```

### Selective Restore (Specific Tables)

```bash
# Extract specific table from backup
gunzip < backup.sql.gz | sed -n -e '/CREATE TABLE.*`inspections`/,/CREATE TABLE/p' > inspections_table.sql

# Restore just that table
mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] < inspections_table.sql
```

### Restore Uploaded Files

```bash
cd /home/alphains/public_html/alphainspections.co.za

# Backup current uploads first
mv storage/app/public storage/app/public_backup

# Restore from backup
tar -xzf ~/backups/production_20250828/uploads.tar.gz

# Set correct permissions
chmod -R 755 storage
chown -R alphains:alphains storage
```

---

## 🚨 EMERGENCY CONTACTS & RECOVERY

### Critical Files to NEVER Delete
- `/storage/app/public/` - All uploaded inspection images
- `/storage/app/reports/` - Generated PDF reports
- `/public/uploads/` - Public uploaded files
- `.env` - Environment configuration
- Database tables: `inspections`, `inspection_images`, `vehicles`, `clients`

### Database Connection Issues

If database connection fails, check:

```bash
# 1. Check .env file has correct credentials
cat .env | grep DB_

# 2. Test database connection
mysql -u [DB_USER] -p[DB_PASSWORD] -h localhost [DB_NAME]

# 3. Check MySQL service
systemctl status mysql
# or
service mysql status
```

### Recovery Priority Order
1. **Restore database first** - This contains all inspection data
2. **Restore uploaded images** - Referenced by database
3. **Restore application code** - Can be redeployed from Git
4. **Restore .env file** - Contains critical configuration

---

## 📋 GIT WORKFLOW FOR PRODUCTION

### Branch Structure
```
main/production  → Production environment (PROTECTED)
staging         → Staging environment (testing)
development     → Active development
```

### Safe Deployment Flow
```bash
# 1. Never commit directly to production
git checkout development
git add .
git commit -m "feat: your changes"
git push origin development

# 2. Merge to staging for testing
git checkout staging
git merge development
git push origin staging
# Test on staging server

# 3. Only after staging is verified, merge to production
git checkout production
git merge staging
git push origin production
# Deploy to production following this guide
```

---

## ⚠️ CRITICAL WARNINGS

### NEVER DO THESE ON PRODUCTION:
1. `php artisan migrate:fresh` - Drops all tables
2. `php artisan migrate:reset` - Drops all tables
3. `php artisan db:wipe` - Drops all tables
4. `rm -rf storage/` - Deletes all uploads
5. `composer update` - Use `composer install` only
6. Direct database modifications without backup
7. Deploy untested code
8. Delete any files in `/storage/app/public/`
9. Truncate inspection-related tables
10. Change APP_KEY after inspections exist

### ALWAYS DO THESE:
1. Test on staging first
2. Create full backup before deployment
3. Check backup integrity
4. Monitor logs after deployment
5. Keep 30 days of backups minimum
6. Store backups off-site
7. Document any manual changes
8. Verify inspection count before/after deployment

---

## 📞 SUPPORT INFORMATION

Server Provider: [Your hosting provider]
SSH Access: Port 22000
Primary Domain: alphainspections.co.za
Staging Domain: staging.alphainspections.co.za

### Backup Locations:
- Server: `~/backups/`
- Local: `F:\Xampp\htdocs\vehicle-inspection\backups\`
- Cloud: [Configure your cloud backup location]

### Critical Paths:
- Production: `/home/alphains/public_html/alphainspections.co.za`
- Staging: `/home/alphains/public_html/staging.alphainspections.co.za`
- Backups: `/home/alphains/backups/`

---

**Last Review Date:** August 28, 2025
**Document Version:** 1.0
**Author:** System Documentation

⚠️ **REMEMBER: When in doubt, don't deploy. Ask for help first!**