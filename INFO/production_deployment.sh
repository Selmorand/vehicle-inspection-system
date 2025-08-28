#!/bin/bash

##############################################
# PRODUCTION DEPLOYMENT SCRIPT
# Vehicle Inspection System
# Date: August 2024
# 
# This script safely deploys changes to production
# while preserving all existing data
##############################################

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  Production Deployment Script${NC}"
echo -e "${GREEN}========================================${NC}"

# Configuration - UPDATE THESE
DB_NAME="your_production_db"
DB_USER="your_db_user"
PRODUCTION_PATH="/home/alphains/public_html/alphainspections.co.za"
BACKUP_DIR="/home/alphains/backups"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

##############################################
# STEP 1: BACKUP DATABASE
##############################################
echo -e "\n${YELLOW}Step 1: Creating database backup...${NC}"

TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="$BACKUP_DIR/production_backup_$TIMESTAMP.sql"

# Create database backup
mysqldump -u $DB_USER -p $DB_NAME > $BACKUP_FILE

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database backed up to: $BACKUP_FILE${NC}"
    
    # Compress the backup
    gzip $BACKUP_FILE
    echo -e "${GREEN}✓ Backup compressed: ${BACKUP_FILE}.gz${NC}"
else
    echo -e "${RED}✗ Database backup failed! Aborting deployment.${NC}"
    exit 1
fi

##############################################
# STEP 2: BACKUP FILES
##############################################
echo -e "\n${YELLOW}Step 2: Creating files backup...${NC}"

cd $PRODUCTION_PATH
tar -czf "$BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz" \
    public/inspection_images/ \
    public/images/panels/ \
    storage/app/

echo -e "${GREEN}✓ Files backed up to: $BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz${NC}"

##############################################
# STEP 3: PULL LATEST CODE
##############################################
echo -e "\n${YELLOW}Step 3: Pulling latest code from production branch...${NC}"

cd $PRODUCTION_PATH

# Show current status
git status

# Pull latest changes
git fetch origin
git checkout production
git pull origin production

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Code updated successfully${NC}"
else
    echo -e "${RED}✗ Git pull failed! Check for conflicts.${NC}"
    exit 1
fi

##############################################
# STEP 4: INSTALL DEPENDENCIES
##############################################
echo -e "\n${YELLOW}Step 4: Installing dependencies...${NC}"

# Update composer dependencies (if composer.lock changed)
if git diff HEAD@{1} --name-only | grep -q "composer.lock"; then
    echo "Composer dependencies changed, updating..."
    composer install --no-dev --optimize-autoloader
else
    echo "No composer changes detected"
fi

##############################################
# STEP 5: RUN MIGRATIONS SAFELY
##############################################
echo -e "\n${YELLOW}Step 5: Running database migrations...${NC}"

# First check migration status
php artisan migrate:status

# Ask for confirmation
read -p "Do you want to proceed with migrations? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Skipping migrations${NC}"
else
    php artisan migrate --force
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Migrations completed successfully${NC}"
    else
        echo -e "${RED}✗ Migration failed! Check the error above.${NC}"
        echo -e "${YELLOW}You may need to run the fix script below.${NC}"
    fi
fi

##############################################
# STEP 6: CLEAR AND REBUILD CACHES
##############################################
echo -e "\n${YELLOW}Step 6: Clearing and rebuilding caches...${NC}"

php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "${GREEN}✓ Caches rebuilt${NC}"

##############################################
# STEP 7: SET PERMISSIONS
##############################################
echo -e "\n${YELLOW}Step 7: Setting correct permissions...${NC}"

# Ensure storage and cache directories are writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/inspection_images

echo -e "${GREEN}✓ Permissions set${NC}"

##############################################
# STEP 8: VERIFY DEPLOYMENT
##############################################
echo -e "\n${YELLOW}Step 8: Verifying deployment...${NC}"

# Check if site is responding
HTTP_STATUS=$(curl -o /dev/null -s -w "%{http_code}\n" https://alphainspections.co.za)

if [ $HTTP_STATUS -eq 200 ]; then
    echo -e "${GREEN}✓ Site is responding correctly (HTTP $HTTP_STATUS)${NC}"
else
    echo -e "${RED}✗ Site returned HTTP $HTTP_STATUS - Please check!${NC}"
fi

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}  Deployment Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "\n${YELLOW}Backup files location:${NC}"
echo -e "  Database: ${BACKUP_FILE}.gz"
echo -e "  Files: $BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz"
echo -e "\n${YELLOW}Please test the following:${NC}"
echo -e "  1. Login functionality"
echo -e "  2. Create new inspection"
echo -e "  3. View existing reports"
echo -e "  4. Check new features (skirting panels, road test, etc.)"