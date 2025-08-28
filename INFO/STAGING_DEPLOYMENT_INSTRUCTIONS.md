# Manual Staging Deployment Instructions

## Problem Identified
The GitHub Actions FTP deployment is failing silently - the workflow runs without errors but doesn't actually upload files to the staging server. This is why you see:
- Laravel welcome page (old cached files)
- Missing Laravel files in diagnostic
- 500 errors on reports page
- Database connection issues

## Solution: Manual Upload

I've prepared a complete deployment in the `deployment` folder with all necessary files and correct configuration.

## Step 1: Upload Files via FTP

**Upload the ENTIRE contents of the `deployment` folder to your staging server:**

**FTP Details:**
- Host: `wp20.domains.co.za`
- Username: `profirea`
- Password: `tv1+TkUY53@1Yz`
- Directory: `/public_html/alpha.selpro.co.za/`

**Important:** Upload ALL files and folders inside `deployment` to the root of `/public_html/alpha.selpro.co.za/`

The deployment includes:
- ✅ All Laravel framework files (app, bootstrap, config, etc.)
- ✅ All vendor dependencies (including DomPDF)
- ✅ Correct .env file with staging database credentials
- ✅ Fixed index.php paths for shared hosting
- ✅ All your application files and views
- ✅ Diagnostic scripts (staging-test.php)

## Step 2: Set Folder Permissions

After upload, set these folder permissions on the server:
- `storage/` folder: **755**
- `bootstrap/cache/` folder: **755**

## Step 3: Run Commands on Server

### Option 1: Via cPanel Terminal (Easiest)
1. Log into your cPanel at domains.co.za
2. Look for "Terminal" or "SSH Access" in the Advanced section
3. Navigate to your site directory:
   ```bash
   cd public_html/alpha.selpro.co.za
   ```
4. Run the commands:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

### Option 2: Via SSH (If Available)
1. Use an SSH client like PuTTY (Windows) or Terminal (Mac/Linux)
2. Connect to: `ssh profirea@wp20.domains.co.za`
3. Navigate to your site:
   ```bash
   cd public_html/alpha.selpro.co.za
   ```
4. Run the commands

### Option 3: Create a Web Script (If No SSH/Terminal Access)
If you don't have SSH or terminal access, create this file and upload it:

**artisan-web.php** (upload to root of alpha.selpro.co.za):
```php
<?php
// IMPORTANT: DELETE THIS FILE AFTER RUNNING!

// Navigate to Laravel directory
chdir(__DIR__);

// Run artisan commands
echo "<h1>Running Artisan Commands</h1>";

// Generate key
echo "<h2>Generating Application Key...</h2>";
exec('php artisan key:generate 2>&1', $output1);
echo "<pre>" . implode("\n", $output1) . "</pre>";

// Run migrations
echo "<h2>Running Migrations...</h2>";
exec('php artisan migrate --force 2>&1', $output2);
echo "<pre>" . implode("\n", $output2) . "</pre>";

// Clear caches
echo "<h2>Clearing Caches...</h2>";
exec('php artisan config:clear 2>&1', $output3);
echo "<pre>" . implode("\n", $output3) . "</pre>";

echo "<hr>";
echo "<p style='color: red;'><strong>IMPORTANT: Delete this file immediately after use!</strong></p>";
?>
```

Then visit: https://alpha.selpro.co.za/artisan-web.php

**DELETE THE FILE IMMEDIATELY AFTER RUNNING!**

### Option 4: Via Hosting Control Panel
Some hosts provide a "Run Command" feature in their control panel. Check if your hosting provider has this option.

## Commands to Run:

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Step 4: Test Deployment

After upload and setup:

1. **Test basic access:** https://alpha.selpro.co.za
   - Should show your Laravel application, NOT the welcome page

2. **Test diagnostics:** https://alpha.selpro.co.za/staging-test.php
   - Should show all green checkmarks for Laravel files
   - Should show successful database connection
   - Should show DomPDF installed

3. **Test reports:** https://alpha.selpro.co.za/reports
   - Should work without 500 error
   - Should show empty reports list with "No reports found"

4. **Test web reports:** Create a test inspection and view the web report

## Why GitHub Actions Failed

The FTP deployment step in GitHub Actions is not working properly. Possible causes:
- FTP credentials issues
- Network connectivity problems
- File permission issues during upload
- The FTP action not connecting to the correct directory

## Future Fix

After confirming manual deployment works, we can investigate and fix the GitHub Actions workflow. For now, manual deployment will get your staging environment working immediately.

## Files Included in Deployment

The deployment folder contains:
- Complete Laravel 12 framework
- All your custom controllers and models
- Web report system with Lightbox2
- PDF generation with DomPDF
- Database migrations
- Staging environment configuration
- All assets (CSS, JS, images)

This is a complete, production-ready deployment of your application.