# Staging Server Deployment Checklist

## Pre-Deployment Requirements

### Server Requirements:
- [ ] PHP 8.2+ installed
- [ ] MySQL 8.0+ installed  
- [ ] Composer installed
- [ ] Web server (Apache/Nginx) configured
- [ ] SSL certificate configured
- [ ] GD or Imagick extension for image processing

### Database Setup:
- [ ] Create MySQL database: `vehicle_inspection_staging`
- [ ] Create database user with full privileges
- [ ] Note down: host, port, username, password

## Deployment Steps

### 1. Upload Files
```bash
# Upload entire project excluding:
- /vendor (will be installed via composer)
- /node_modules  
- /.env (use .env.staging as template)
- /storage/app/* (except .gitkeep files)
- /storage/logs/*
- /bootstrap/cache/*
```

### 2. Server Configuration
- [ ] Update `.env.staging` with actual values:
  - `APP_URL` → Your staging domain
  - `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
  - SMTP settings if using email notifications
- [ ] Rename `.env.staging` to `.env`
- [ ] Run deployment script: `bash deploy-staging.sh`

### 3. Web Server Setup
```nginx
# Nginx example
server {
    listen 443 ssl;
    server_name your-staging-domain.com;
    root /path/to/vehicle-inspection/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        client_max_body_size 100M;
    }

    # SSL configuration...
}
```

### 4. Post-Deployment Testing
- [ ] Visit staging URL - should show login/dashboard
- [ ] Test database connection
- [ ] Create test inspection
- [ ] Test image upload functionality  
- [ ] Test PDF generation
- [ ] Test on tablet device
- [ ] Check error logs: `tail -f storage/logs/laravel.log`

### 5. Security Checklist
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=staging`
- [ ] Strong database password
- [ ] File permissions: 755 for directories, 644 for files
- [ ] Web server configured to only serve /public
- [ ] SSL certificate valid and working

## Troubleshooting

### Common Issues:
1. **500 Error**: Check `storage/logs/laravel.log`
2. **Permission Issues**: `chown -R www-data:www-data storage bootstrap/cache`
3. **Database Connection**: Verify credentials in `.env`
4. **Missing Dependencies**: Run `composer install`
5. **Config Cache**: Clear with `php artisan config:clear`

### Important Files to Monitor:
- `/storage/logs/laravel.log`
- `/storage/app/public/uploads/` (inspection images)
- Database tables: `inspections`, `inspection_images`, etc.