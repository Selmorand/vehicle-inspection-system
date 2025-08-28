# STAGING DEPLOYMENT CHECKLIST - Email Functionality

## Files That Are NOT Committed to Git (Must be deployed manually):

### 1. ❌ .htaccess (CRITICAL - Missing on staging)
**Location:** Root directory
**Content:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```
**Why needed:** Redirects all requests to Laravel's public folder on shared hosting

### 2. ❌ .env Mail Configuration (CRITICAL - Missing on staging)
**Add these lines to staging .env:**
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.alphainspections.co.za
MAIL_PORT=587
MAIL_USERNAME=report@alphainspections.co.za
MAIL_PASSWORD=tNT@HZsJbj9]
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="report@alphainspections.co.za"
MAIL_FROM_NAME="Alpha Inspections"
```

### 3. ❌ Storage Directories (Create if missing)
```bash
mkdir -p storage/app/public/reports
mkdir -p storage/app/temp
chmod -R 775 storage/app/public/reports
chmod -R 775 storage/app/temp
```

## Files That WERE Committed (Should be deployed via git pull):
✅ app/Http/Controllers/ReportController.php
✅ app/Mail/InspectionReportMail.php  
✅ app/Services/PdfService.php
✅ resources/views/reports/index.blade.php
✅ resources/views/emails/inspection-report.blade.php
✅ routes/web.php

## DEPLOYMENT COMMANDS FOR STAGING:

### Step 1: Upload .htaccess
```bash
# Create .htaccess in root directory (NOT in public folder)
cat > /home/alphains/public_html/staging.alphainspections.co.za/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF
```

### Step 2: Update .env
```bash
cd /home/alphains/public_html/staging.alphainspections.co.za

# Add mail configuration to .env
cat >> .env << 'EOF'

MAIL_MAILER=smtp
MAIL_HOST=mail.alphainspections.co.za
MAIL_PORT=587
MAIL_USERNAME=report@alphainspections.co.za
MAIL_PASSWORD=tNT@HZsJbj9]
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="report@alphainspections.co.za"
MAIL_FROM_NAME="Alpha Inspections"
EOF
```

### Step 3: Create Storage Directories
```bash
mkdir -p storage/app/public/reports
mkdir -p storage/app/temp
chmod -R 775 storage bootstrap/cache
chmod -R 775 storage/app/public/reports
```

### Step 4: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
```

### Step 5: Test
```bash
curl -I https://staging.alphainspections.co.za
curl "https://staging.alphainspections.co.za/test-simple-email"
```

## SSH One-Liner to Fix Everything:
```bash
ssh alphains@staging.alphainspections.co.za "
cd /home/alphains/public_html/staging.alphainspections.co.za &&
echo '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)\$ public/\$1 [L]
</IfModule>' > .htaccess &&
mkdir -p storage/app/public/reports storage/app/temp &&
chmod -R 775 storage bootstrap/cache &&
php artisan config:clear &&
php artisan cache:clear &&
php artisan config:cache &&
curl -I https://staging.alphainspections.co.za
"
```