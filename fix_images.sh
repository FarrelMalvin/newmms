#!/bin/bash

echo "🔧 Fixing Image Issues for MMS Project"
echo "======================================"

# 1. Create storage symlink
echo "📁 Creating storage symlink..."
php artisan storage:link

# 2. Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage/
chmod -R 755 public/storage/
chmod -R 755 bootstrap/cache/

# 3. Create upload directories if they don't exist
echo "📂 Creating upload directories..."
mkdir -p storage/app/public/uploads/produk
mkdir -p storage/app/public/uploads/featured
chmod -R 755 storage/app/public/uploads/

# 4. Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 5. Check symlink
echo "🔗 Checking symlink..."
if [ -L "public/storage" ]; then
    echo "✅ Storage symlink exists"
    ls -la public/storage
else
    echo "❌ Storage symlink missing"
    echo "Creating manual symlink..."
    ln -sf ../storage/app/public public/storage
fi

# 6. Test file access
echo "🧪 Testing file access..."
if [ -d "public/storage/uploads" ]; then
    echo "✅ Upload directory accessible"
else
    echo "❌ Upload directory not accessible"
fi

echo ""
echo "🎉 Image fix completed!"
echo ""
echo "Next steps:"
echo "1. Upload images via admin panel"
echo "2. Check if images appear correctly"
echo "3. If still broken, check server logs"
echo ""
echo "For cPanel users:"
echo "- Use File Manager to create symlink manually"
echo "- Set folder permissions to 755"
