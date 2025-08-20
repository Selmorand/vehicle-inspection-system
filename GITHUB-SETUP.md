# GitHub Staging Setup Guide

## 1. GitHub Repository Settings

Your staging branch is now created at:
**https://github.com/Selmorand/vehicle-inspection-system/tree/staging**

## 2. Required GitHub Secrets

Go to: **Settings → Secrets and variables → Actions** in your GitHub repo

Add these secrets for automated deployment:

```
STAGING_HOST          = your-server-ip-or-domain.com
STAGING_USER          = your-ssh-username  
STAGING_SSH_KEY       = your-private-ssh-key-content
STAGING_PORT          = 22 (or your SSH port)
STAGING_PATH          = /path/to/your/staging/directory
STAGING_DB_USER       = your-database-username
STAGING_DB_PASSWORD   = your-database-password  
STAGING_DB_NAME       = vehicle_inspection_staging
STAGING_URL           = https://your-staging-domain.com
```

## 3. SSH Key Setup

### On your local machine:
```bash
# Generate SSH key for deployment
ssh-keygen -t rsa -b 4096 -f ~/.ssh/staging_deploy_key

# Copy public key to server
ssh-copy-id -i ~/.ssh/staging_deploy_key.pub user@your-server.com
```

### Copy private key to GitHub:
```bash
# Display private key to copy to GitHub secrets
cat ~/.ssh/staging_deploy_key
```

## 4. Server-Side Setup

### Option A: Automated (if GitHub Actions configured)
1. Set up SSH access and GitHub secrets
2. Push to staging branch - deployment runs automatically

### Option B: Manual Deployment  
```bash
# On your staging server:
cd /var/www  # or your web root
git clone https://github.com/Selmorand/vehicle-inspection-system.git staging
cd staging
git checkout staging
chmod +x deploy-to-staging.sh
./deploy-to-staging.sh
```

## 5. Web Server Configuration

### Apache (.htaccess in /public already configured)
```apache
<VirtualHost *:443>
    ServerName your-staging-domain.com
    DocumentRoot /path/to/staging/public
    
    # SSL configuration
    SSLEngine on
    SSLCertificateFile /path/to/your/certificate.crt
    SSLCertificateKeyFile /path/to/your/private.key
</VirtualHost>
```

### Nginx
```nginx
server {
    listen 443 ssl;
    server_name your-staging-domain.com;
    root /path/to/staging/public;
    index index.php index.html;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

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
}
```

## 6. Testing the Setup

1. **Push to staging branch** to trigger deployment
2. **Check Actions tab** in GitHub for deployment status
3. **Visit staging URL** to verify it works
4. **Test core functionality**: login, create inspection, upload images

## 7. Deployment Workflow

```bash
# Development workflow:
git checkout main
# Make changes...
git add .
git commit -m "feat: your changes"
git push origin main

# Deploy to staging:
git checkout staging  
git merge main
git push origin staging  # Triggers auto-deployment

# Or manual staging update:
git checkout staging
git cherry-pick <commit-hash>  # Pick specific commits
git push origin staging
```