#!/bin/bash

##############################################
# STAGING DEPLOYMENT HEALTH CHECK
# Run this after every git pull to staging
##############################################

echo "🔍 STAGING HEALTH CHECK STARTING..."

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

STAGING_PATH="/home/alphains/public_html/staging.alphainspections.co.za"
cd $STAGING_PATH

echo -e "\n${YELLOW}1. Clearing all caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo -e "\n${YELLOW}2. Fixing permissions...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/inspection_images

echo -e "\n${YELLOW}3. Regenerating optimized files...${NC}"
composer dump-autoload --optimize
php artisan config:cache
php artisan route:cache

echo -e "\n${YELLOW}4. Checking critical files...${NC}"
if [ -f ".env" ]; then
    echo -e "${GREEN}✓ .env exists${NC}"
else
    echo -e "${RED}✗ .env missing!${NC}"
fi

if [ -d "vendor" ]; then
    echo -e "${GREEN}✓ vendor directory exists${NC}"
else
    echo -e "${RED}✗ vendor missing! Run: composer install${NC}"
fi

echo -e "\n${YELLOW}5. Testing basic routes...${NC}"
php artisan route:list | grep -E "(dashboard|reports)" | head -5

echo -e "\n${YELLOW}6. Checking storage directories...${NC}"
mkdir -p storage/app/public/reports
mkdir -p storage/logs
mkdir -p public/inspection_images

echo -e "\n${YELLOW}7. Testing application...${NC}"
HTTP_STATUS=$(curl -o /dev/null -s -w "%{http_code}\n" https://staging.alphainspections.co.za)

if [ $HTTP_STATUS -eq 200 ]; then
    echo -e "${GREEN}✅ STAGING IS HEALTHY (HTTP $HTTP_STATUS)${NC}"
else
    echo -e "${RED}❌ STAGING RETURNING HTTP $HTTP_STATUS${NC}"
    echo -e "${YELLOW}Check logs: tail -f storage/logs/laravel.log${NC}"
fi

echo -e "\n${YELLOW}8. Recent Laravel logs:${NC}"
tail -10 storage/logs/laravel.log 2>/dev/null || echo "No recent Laravel logs"

echo -e "\n🏁 HEALTH CHECK COMPLETE"