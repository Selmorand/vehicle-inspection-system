# GitHub Staging Setup Guide

## 1. GitHub Repository Settings

Your staging branch is now created at:
**https://github.com/Selmorand/vehicle-inspection-system/tree/staging**

## 2. Required GitHub Secrets

Go to: **Settings → Secrets and variables → Actions** in your GitHub repo

Add these secrets for automated deployment:

```
STAGING_HOST          = 169.239.218.62 
STAGING_USER          = selproho  
STAGING_SSH_KEY       = your-private-ssh-key-content
STAGING_PORT          = 22
STAGING_PATH          = /public_html/staging.alphainspections.co.za
STAGING_DB_USER       = alpha_staging
STAGING_DB_PASSWORD   = your-database-password  
STAGING_DB_NAME       = alpha_staging
STAGING_URL           = https://staging.alphainspections.co.za
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
cd /public_html
git clone https://github.com/Selmorand/vehicle-inspection-system.git staging.alphainspections.co.za
cd staging.alphainspections.co.za
git checkout staging
chmod +x deploy-to-staging.sh
./deploy-to-staging.sh
```

## 5. Web Server Configuration

### Apache (.htaccess in /public already configured)
```apache
<VirtualHost *:443>
    ServerName staging.alphainspections.co.za
    DocumentRoot /public_html/staging.alphainspections.co.za/public
    
    # SSL configuration
    SSLEngine on
    SSLCertificateFile /path/to/your/certificate.crt
    SSLCertificateKeyFile /path/to/your/private.key
</VirtualHost>
```

### cPanel Subdomain Setup (Recommended for this host)
1. **Login to cPanel**: https://cp62.domains.co.za:2083
2. **Go to Subdomains**
3. **Create Subdomain**: `staging` 
4. **Document Root**: `/public_html/staging.alphainspections.co.za/public`
5. **Domain**: `alphainspections.co.za`

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