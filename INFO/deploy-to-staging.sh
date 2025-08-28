#!/bin/bash

# Manual Staging Deployment Script
# Run this on your staging server after cloning the repo

echo "🎯 Vehicle Inspection System - Manual Staging Deployment"
echo "========================================================"

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel root directory. Please cd to your project root."
    exit 1
fi

# Check if git repo exists
if [ ! -d ".git" ]; then
    echo "❌ Error: No git repository found. Please clone the repo first."
    echo "   Run: git clone https://github.com/Selmorand/vehicle-inspection-system.git"
    exit 1
fi

# Switch to staging branch
echo "🔀 Switching to staging branch..."
git checkout staging
git pull origin staging

# Copy environment template
echo "📋 Setting up environment file..."
if [ -f ".env.staging.template" ]; then
    cp .env.staging.template .env
    echo "✅ Copied .env.staging.template to .env"
else
    echo "❌ Error: .env.staging.template not found!"
    exit 1
fi

echo ""
echo "⚠️  IMPORTANT: You must now edit .env with your actual values:"
echo "   - Database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)"  
echo "   - App URL (APP_URL)"
echo "   - Mail settings (if using notifications)"
echo ""
read -p "Press Enter after you've updated .env with your values..."

# Run the deployment script
echo "🚀 Running deployment script..."
chmod +x deploy-staging.sh
./deploy-staging.sh

echo ""
echo "🎉 Deployment complete!"
echo ""
echo "Next steps:"
echo "1. Configure your web server to point to the /public directory"
echo "2. Test the application: visit your staging URL"
echo "3. Check logs if issues: tail -f storage/logs/laravel.log"