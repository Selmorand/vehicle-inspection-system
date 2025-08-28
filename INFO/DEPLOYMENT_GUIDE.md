# Vehicle Inspection System - Deployment Guide for Domains.co.za

## Pre-Deployment Checklist

### 1. Export Your Local Database
1. Open phpMyAdmin in XAMPP: `http://localhost/phpmyadmin`
2. Select your vehicle inspection database
3. Click "Export" → Choose "Quick" method → Format: SQL
4. Save the .sql file

### 2. Prepare Files for Upload

#### Create Production .env file
Create a new file called `.env.production` with these settings:
```
APP_NAME="ALPHA Vehicle Inspection"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.co.za

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 3. Files to Exclude from Upload
Do NOT upload these folders/files:
- `/node_modules` (if exists)
- `/tests`
- `/.git`
- `/storage/app/public/*` (user uploads)
- `/storage/logs/*`
- `.env` (local file)
- `CLAUDE.md`
- `newPrompt.md`
- Screenshots folder
- Any .log files

### 4. Essential Folders to Create on Server
After upload, create these folders with 755 permissions:
- `/storage/framework/cache`
- `/storage/framework/sessions`
- `/storage/framework/views`
- `/storage/logs`
- `/bootstrap/cache`

## Step-by-Step Deployment Process

### Step 1: Database Setup
1. Log into your Domains.co.za control panel
2. Create a new MySQL database
3. Create a database user with full privileges
4. Import your .sql file using phpMyAdmin

### Step 2: File Upload
1. Create a zip file of your project (excluding items mentioned above)
2. Upload via:
   - FTP client (like FileZilla), OR
   - File Manager in control panel, OR
   - Import button if available
3. Extract files to your public_html or subdomain folder

### Step 3: Configuration
1. Rename `.env.production` to `.env`
2. Update database credentials in `.env`
3. Generate new APP_KEY:
   - SSH into server (if available): `php artisan key:generate`
   - OR manually generate a base64 key

### Step 4: Set Permissions
```bash
# If you have SSH access:
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# If using File Manager:
# Right-click folders → Permissions → Set to 755
```

### Step 5: Configure Web Server
Create/edit `.htaccess` in your root folder:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Create/edit `public/.htaccess`:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Step 6: Run Migrations (if needed)
If you have SSH access:
```bash
php artisan migrate --force
php artisan storage:link
```

If no SSH access, ensure your database import included all tables.

## Common Issues & Solutions

### Issue: 500 Internal Server Error
- Check `.env` file exists and has correct settings
- Verify PHP version is 8.2+
- Check error logs in `/storage/logs`

### Issue: Stylesheet/Images not loading
- Run: `php artisan storage:link`
- Check APP_URL in .env matches your domain
- Verify `/public` folder permissions

### Issue: "Class not found" errors
- Upload `/vendor` folder if not using Composer on server
- Run `composer install --no-dev` if Composer available

### Issue: Database connection refused
- Verify database credentials
- Check if DB_HOST should be 'localhost' or specific server

## Testing Checklist
1. ✅ Homepage loads without errors
2. ✅ Can navigate to `/dashboard`
3. ✅ Images and CSS load correctly
4. ✅ Can start new inspection
5. ✅ Form submissions work
6. ✅ Image uploads function properly

## Optimization for Production

### 1. Enable Caching
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize Autoloader
```bash
composer install --optimize-autoloader --no-dev
```

### 3. Security Headers
Add to `.htaccess`:
```apache
# Security Headers
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "SAMEORIGIN"
Header set X-XSS-Protection "1; mode=block"
```

## Contact Support
If you encounter issues:
1. Check Domains.co.za knowledge base
2. Contact their support with:
   - PHP version on server
   - Error messages
   - Laravel 12 requirements

Good luck with your deployment!