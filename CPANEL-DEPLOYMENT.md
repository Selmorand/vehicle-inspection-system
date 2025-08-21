# cPanel Manual Deployment Guide

Since SSH access appears blocked, use cPanel's built-in tools:

## Method 1: cPanel Git Version Control (Recommended)

1. **Login to cPanel:** https://cp62.domains.co.za:2083
   - Username: `selproho`
   - Password: `Kp(x1@cMqZ1M83`

2. **Setup Git Repository:**
   - Go to: **Git Version Control**
   - Click: **Create**
   - Repository URL: `https://github.com/Selmorand/vehicle-inspection-system.git`
   - Repository Path: `/public_html/staging.alphainspections.co.za`
   - Repository Name: `Vehicle Inspection Staging`
   - Click: **Create**

3. **Switch to Staging Branch:**
   - Click: **Manage** on the repository
   - Go to: **Pull or Deploy** tab
   - Update Branch: Change from `main` to `staging`
   - Click: **Update from Remote**

4. **Setup Environment:**
   - In cPanel File Manager, navigate to: `/public_html/staging.alphainspections.co.za`
   - Copy `.env.staging.template` to `.env`
   - Edit `.env` file:
     ```
     APP_KEY=base64:GENERATE_A_KEY_HERE
     APP_URL=https://staging.alphainspections.co.za
     DB_HOST=localhost
     DB_DATABASE=alphains_staging
     DB_USERNAME=alphains_staging
     DB_PASSWORD=~cMS4%Xn!g1c
     ```

5. **Install Dependencies via Terminal (if available):**
   - Go to: **Terminal** in cPanel
   - Run:
     ```bash
     cd /public_html/staging.alphainspections.co.za
     composer install --no-dev --optimize-autoloader
     php artisan key:generate
     php artisan migrate --force
     php artisan storage:link
     php artisan config:cache
     php artisan route:cache
     ```

## Method 2: Manual Upload via File Manager

1. **Download deployment package locally:**
   ```bash
   git archive --format=zip --output=staging-deploy.zip staging
   ```

2. **Upload to cPanel:**
   - Go to: **File Manager**
   - Navigate to: `/public_html`
   - Create folder: `staging.alphainspections.co.za`
   - Upload: `staging-deploy.zip`
   - Extract files

3. **Configure environment** (same as Method 1, step 4)

4. **Run setup commands** (same as Method 1, step 5)

## Method 3: FTP Upload

1. **FTP Details:**
   - Host: `ftp.selprohost.co.za` or `169.239.218.62`
   - Username: `selproho`
   - Password: `Kp(x1@cMqZ1M83`
   - Directory: `/public_html/staging.alphainspections.co.za`

2. **Upload all files except:**
   - `/vendor` folder
   - `/node_modules` folder
   - `.env` file

3. **After upload, use cPanel Terminal to run setup commands**

## Post-Deployment Checklist

- [ ] Environment file configured with correct database
- [ ] Application key generated
- [ ] Database migrations run
- [ ] Storage link created
- [ ] Proper file permissions set (755 for directories, 644 for files)
- [ ] Subdomain configured to point to `/public` folder
- [ ] Test site at: https://staging.alphainspections.co.za

## Troubleshooting

- **500 Error:** Check `/storage/logs/laravel.log`
- **Database Error:** Verify credentials in `.env`
- **Missing Dependencies:** Run `composer install` in Terminal
- **Permission Issues:** Set proper permissions on `/storage` and `/bootstrap/cache`