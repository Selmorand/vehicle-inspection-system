#!/bin/bash
# PRODUCTION BACKUP SCRIPT - ALPHA INSPECTIONS
# Run this before ANY production deployment

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}   ALPHA INSPECTIONS PRODUCTION BACKUP  ${NC}"
echo -e "${GREEN}=========================================${NC}"

# Configuration
BACKUP_BASE_DIR="$HOME/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="$BACKUP_BASE_DIR/production_$TIMESTAMP"
SITE_DIR="/home/alphains/public_html/alphainspections.co.za"

# Database credentials - UPDATE THESE!
DB_NAME="your_database_name"
DB_USER="your_database_user"
DB_PASS="your_database_password"

# Create backup directory
echo -e "${YELLOW}Creating backup directory...${NC}"
mkdir -p $BACKUP_DIR

# Navigate to site directory
cd $SITE_DIR

# 1. Backup Database
echo -e "${YELLOW}Backing up database...${NC}"
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/database.sql
if [ $? -eq 0 ]; then
    gzip $BACKUP_DIR/database.sql
    echo -e "${GREEN}✓ Database backed up successfully${NC}"
else
    echo -e "${RED}✗ Database backup failed!${NC}"
    exit 1
fi

# 2. Count records for verification
echo -e "${YELLOW}Recording inspection counts...${NC}"
mysql -u $DB_USER -p$DB_PASS $DB_NAME -e "SELECT COUNT(*) as count FROM inspections;" > $BACKUP_DIR/inspection_count.txt
mysql -u $DB_USER -p$DB_PASS $DB_NAME -e "SELECT COUNT(*) as count FROM inspection_images;" >> $BACKUP_DIR/inspection_count.txt

# 3. Backup uploaded images and files
echo -e "${YELLOW}Backing up uploaded files...${NC}"
tar -czf $BACKUP_DIR/storage_uploads.tar.gz storage/app/public/ 2>/dev/null
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Uploaded files backed up${NC}"
else
    echo -e "${YELLOW}⚠ Some files might be missing (this is usually okay)${NC}"
fi

# 4. Backup public uploads
if [ -d "public/uploads" ]; then
    tar -czf $BACKUP_DIR/public_uploads.tar.gz public/uploads/
    echo -e "${GREEN}✓ Public uploads backed up${NC}"
fi

# 5. Backup reports (PDFs)
if [ -d "storage/app/reports" ]; then
    tar -czf $BACKUP_DIR/reports.tar.gz storage/app/reports/
    echo -e "${GREEN}✓ PDF reports backed up${NC}"
fi

# 6. Backup .env file
cp .env $BACKUP_DIR/.env.backup
echo -e "${GREEN}✓ Environment file backed up${NC}"

# 7. Create backup info file
echo "Backup created: $(date)" > $BACKUP_DIR/backup_info.txt
echo "Server: alphainspections.co.za" >> $BACKUP_DIR/backup_info.txt
echo "Directory: $SITE_DIR" >> $BACKUP_DIR/backup_info.txt
echo "" >> $BACKUP_DIR/backup_info.txt
echo "Files included:" >> $BACKUP_DIR/backup_info.txt
ls -lh $BACKUP_DIR >> $BACKUP_DIR/backup_info.txt

# 8. Calculate backup size
BACKUP_SIZE=$(du -sh $BACKUP_DIR | cut -f1)

# 9. Clean old backups (keep last 30 days)
echo -e "${YELLOW}Cleaning old backups...${NC}"
find $BACKUP_BASE_DIR -name "production_*" -mtime +30 -delete
echo -e "${GREEN}✓ Old backups cleaned${NC}"

# Final report
echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}       BACKUP COMPLETED SUCCESSFULLY     ${NC}"
echo -e "${GREEN}=========================================${NC}"
echo -e "Backup Location: ${YELLOW}$BACKUP_DIR${NC}"
echo -e "Backup Size: ${YELLOW}$BACKUP_SIZE${NC}"
echo -e "Timestamp: ${YELLOW}$TIMESTAMP${NC}"
echo ""
echo -e "${YELLOW}IMPORTANT NEXT STEPS:${NC}"
echo "1. Download this backup to your local machine:"
echo -e "   ${GREEN}scp -P 22000 -r alphains@alphainspections.co.za:$BACKUP_DIR ./local_backups/${NC}"
echo "2. Verify the backup integrity"
echo "3. Store a copy off-site (cloud storage, external drive, etc.)"
echo ""
echo -e "${RED}Remember: Never deploy to production without a recent backup!${NC}"