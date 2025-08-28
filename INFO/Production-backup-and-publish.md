● ✅ CRITICAL PRODUCTION GUIDE CREATED

  I've created three essential files:

  1. PRODUCTION_DEPLOYMENT_GUIDE.md - Complete Guide

  - Full deployment checklist with safety warnings  
  - Step-by-step backup procedures
  - Database restore instructions
  - Emergency rollback procedures
  - Critical warnings about what NEVER to do on production

  2. backup_production.sh - Automated Backup Script

  - Creates timestamped backups of database, files, and reports
  - Verifies backup integrity
  - Includes inspection counts for validation
  - Provides download instructions for off-site storage

  3. quick_deploy_production.sh - Deployment Script

  - Safety confirmation required before proceeding
  - Maintenance mode during deployment
  - Health checks after deployment
  - Clear instructions for post-deployment testing

  🔴 KEY SAFETY POINTS:

  1. NEVER deploy without backup - The backup script creates full database + files backup
  2. Reports are protected - All procedures preserve existing inspection data
  3. Rollback ready - Detailed steps to undo deployment if needed
  4. Test staging first - Mandatory staging verification before production
  5. Off-site backups - Instructions to download backups locally/cloud

  📋 Quick Reference:

  # 1. Create backup (ALWAYS FIRST)
  ./backup_production.sh

  # 2. Deploy to production (only after backup + staging test)
  ./quick_deploy_production.sh

  The guide ensures zero data loss and safe deployments to production!

> where does it back the database in the event we need to restore

● Looking at the backup scripts I created, here are the exact locations where database backups are
  stored:

  📍 Database Backup Locations

  Primary Backup Location (On Server):

  /home/alphains/backups/production_YYYYMMDD_HHMMSS/database.sql.gz

  Example:
  /home/alphains/backups/production_20250828_143022/database.sql.gz

  Backup Directory Structure:

  /home/alphains/
  ├── backups/
  │   ├── production_20250828_143022/
  │   │   ├── database.sql.gz          ← DATABASE BACKUP HERE
  │   │   ├── storage_uploads.tar.gz   ← Uploaded images
  │   │   ├── public_uploads.tar.gz    ← Public files
  │   │   ├── reports.tar.gz           ← PDF reports
  │   │   ├── .env.backup              ← Environment file
  │   │   ├── backup_info.txt          ← Backup details
  │   │   └── inspection_count.txt     ← Record counts for verification
  │   ├── production_20250827_120000/  ← Previous backup
  │   └── production_20250826_020000/  ← Older backup

  🔄 How to Restore Database:

  Step 1: Find Available Backups

  ssh -p 22000 alphains@alphainspections.co.za
  ls -la ~/backups/

  Step 2: Restore from Backup

  # Navigate to production directory
  cd /home/alphains/public_html/alphainspections.co.za

  # Choose your backup (replace TIMESTAMP with actual backup)
  BACKUP_PATH="~/backups/production_20250828_143022"

  # Restore database
  gunzip < $BACKUP_PATH/database.sql.gz | mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME]

  # Clear Laravel caches after restore
  php artisan config:clear
  php artisan cache:clear

  💾 Off-Site Backup Storage (CRITICAL):

  The guide recommends downloading backups to multiple locations:

  Download to Local Machine:

  # Download entire backup folder
  scp -P 22000 -r alphains@alphainspections.co.za:~/backups/production_20250828_143022
  ./local_backups/

  # Or just the database
  scp -P 22000 alphains@alphainspections.co.za:~/backups/production_20250828_143022/database.sql.gz      
  ./db_backups/

  Recommended Storage Locations:

  1. Server: /home/alphains/backups/ (primary - 30 days retention)
  2. Local: F:\Xampp\htdocs\vehicle-inspection\backups\ (secondary)
  3. Cloud Storage: Google Drive, Dropbox, AWS S3, etc. (off-site safety)
  4. External Drive: Physical backup for ultimate safety

  ⚠️ Important Notes:

  1. Automatic Cleanup: Server keeps only 30 days of backups automatically
  2. Manual Download Required: You must manually download critical backups for long-term storage
  3. Database Credentials: You'll need the actual DB credentials from the .env file
  4. Compressed Format: Database backups are gzipped to save space

  🚨 Emergency Database Recovery:

  If production database fails completely:

  # 1. Find most recent backup
  ls -t ~/backups/production_*/database.sql.gz | head -1

  # 2. Restore immediately
  LATEST_BACKUP=$(ls -t ~/backups/production_*/database.sql.gz | head -1)
  gunzip < $LATEST_BACKUP | mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME]

  # 3. Verify restoration
  mysql -u [DB_USER] -p[DB_PASSWORD] [DB_NAME] -e "SELECT COUNT(*) FROM inspections;"

  The backup system ensures you always have a path back to your inspection data!