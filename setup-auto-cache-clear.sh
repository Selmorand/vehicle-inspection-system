#!/bin/bash

echo "🔧 Setting up automatic cache clearing on server..."

# 1. Setup git hook for automatic cache clearing after pull
echo "📝 Creating git post-merge hook..."
cat > .git/hooks/post-merge << 'EOF'
#!/bin/bash
echo "🔄 Running automatic cache clear after git pull..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Cache cleared automatically!"
EOF

chmod +x .git/hooks/post-merge
echo "✅ Git hook installed!"

# 2. Create alias for easy cache clearing
echo "📝 Creating cache clear alias..."
echo "alias cc='php artisan optimize:clear && php artisan optimize'" >> ~/.bashrc
source ~/.bashrc
echo "✅ Alias 'cc' created for quick cache clearing!"

# 3. Add cache clear key to .env
echo "📝 Adding cache clear key to .env..."
if ! grep -q "CACHE_CLEAR_KEY" .env; then
    echo "" >> .env
    echo "# Cache clear security key" >> .env
    echo "CACHE_CLEAR_KEY=staging_clear_2025_$(date +%s)" >> .env
    echo "✅ Cache clear key added to .env!"
else
    echo "⚠️  Cache clear key already exists in .env"
fi

echo ""
echo "✅ Setup complete! Cache will now clear automatically after every git pull"
echo ""
echo "📌 Quick commands:"
echo "   cc              - Clear all caches manually"
echo "   git pull        - Will auto-clear cache after pull"
echo "   Web clear URL   - /clear-cache?key=YOUR_KEY_FROM_ENV"