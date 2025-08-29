#!/bin/bash

# Staging Password Management Script

echo "🔐 Staging Password Management"
echo "=============================="
echo ""
echo "Select an option:"
echo "1) Create test users for staging"
echo "2) Reset all staging passwords"
echo "3) Import user structure from production (safe)"
echo "4) Show current test accounts"
echo "5) Exit"
echo ""
read -p "Choice: " choice

case $choice in
    1)
        echo "Creating test users..."
        php artisan db:seed --class=EnvironmentUserSeeder --force
        ;;
    2)
        echo "Resetting all passwords to test values..."
        php artisan users:sync-from-production --reset-passwords
        ;;
    3)
        echo "Importing production user structure..."
        echo "⚠️  This will copy emails/names but NOT real passwords"
        read -p "Continue? (y/n): " confirm
        if [ "$confirm" = "y" ]; then
            php artisan users:sync-from-production --preserve-admin
        fi
        ;;
    4)
        echo ""
        echo "📋 Test Accounts for Staging:"
        echo "------------------------------"
        echo "Admin:     admin@alphainspections.co.za / StageAdmin2025!"
        echo "Inspector: inspector@alphainspections.co.za / StageInspect2025!"
        echo "Demo:      demo@alphainspections.co.za / DemoUser2025!"
        echo ""
        ;;
    5)
        exit 0
        ;;
    *)
        echo "Invalid option"
        ;;
esac