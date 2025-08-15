#!/bin/bash

echo "🖼️ SETTING UP IMAGES FOR CPANEL"
echo "================================"
echo ""

# 1. Check if storage symlink exists
echo "🔗 STEP 1: Checking storage symlink..."
if [ -L "public/storage" ]; then
    echo "   ✅ Storage symlink exists"
else
    echo "   ❌ Storage symlink missing"
    echo "   📋 Manual step needed: Create symlink in cPanel File Manager"
    echo "      - Name: storage"
    echo "      - Target: ../storage/app/public"
fi

# 2. Create upload directories
echo ""
echo "📁 STEP 2: Creating upload directories..."
mkdir -p storage/app/public/uploads/produk
mkdir -p storage/app/public/uploads/featured
echo "   ✅ Upload directories created"

# 3. Set permissions for directories
echo ""
echo "🔐 STEP 3: Setting directory permissions..."
chmod -R 755 storage/app/public/uploads/
echo "   ✅ Directory permissions set to 755"

# 4. Set permissions for existing images
echo ""
echo "🖼️ STEP 4: Setting image permissions..."
if [ -d "storage/app/public/uploads/produk" ]; then
    find storage/app/public/uploads/produk -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" -o -name "*.gif" | xargs chmod 644
    echo "   ✅ Product image permissions set to 644"
fi

if [ -d "storage/app/public/uploads/featured" ]; then
    find storage/app/public/uploads/featured -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" -o -name "*.gif" | xargs chmod 644
    echo "   ✅ Featured image permissions set to 644"
fi

# 5. Count existing images
echo ""
echo "📊 STEP 5: Counting existing images..."
PRODUCT_COUNT=$(find storage/app/public/uploads/produk -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" -o -name "*.gif" 2>/dev/null | wc -l)
FEATURED_COUNT=$(find storage/app/public/uploads/featured -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" -o -name "*.gif" 2>/dev/null | wc -l)

echo "   📸 Product images: $PRODUCT_COUNT"
echo "   🎯 Featured images: $FEATURED_COUNT"

# 6. Check image sizes
echo ""
echo "📏 STEP 6: Checking image sizes..."
if [ $PRODUCT_COUNT -gt 0 ]; then
    echo "   📋 Product image sizes:"
    find storage/app/public/uploads/produk -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" -o -name "*.gif" | head -5 | while read file; do
        size=$(du -h "$file" | cut -f1)
        echo "      - $(basename "$file"): $size"
    done
fi

# 7. Test image access
echo ""
echo "🧪 STEP 7: Testing image access..."
if [ -d "public/storage" ]; then
    echo "   ✅ Storage symlink accessible"
    if [ -d "public/storage/uploads" ]; then
        echo "   ✅ Upload directory accessible via web"
    else
        echo "   ❌ Upload directory not accessible via web"
    fi
else
    echo "   ❌ Storage symlink not accessible"
fi

# 8. Database check
echo ""
echo "🗄️ STEP 8: Checking database image paths..."
php artisan tinker --execute="
echo 'Checking product images in database...';
\$products = App\Models\Produk::whereNotNull('gambar_produk')->get();
echo 'Found ' . \$products->count() . ' products with images';
foreach(\$products as \$p) {
    echo PHP_EOL . '- ' . \$p->nama_produk . ': ' . \$p->gambar_produk;
}
" 2>/dev/null || echo "   ⚠️ Could not check database (PHP not available)"

echo ""
echo "🎉 IMAGE SETUP COMPLETED!"
echo ""
echo "📋 NEXT STEPS:"
echo "1. Upload images via admin panel"
echo "2. Test image display on website"
echo "3. Check if fallback images work"
echo ""
echo "🔧 IF IMAGES DON'T APPEAR:"
echo "- Create storage symlink in cPanel File Manager"
echo "- Set folder permissions to 755"
echo "- Set image permissions to 644"
echo "- Check .htaccess file"
echo ""
echo "📞 FOR CPANEL USERS:"
echo "- Use File Manager to create symlink manually"
echo "- Upload images via admin panel (recommended)"
echo "- Or upload directly to storage/app/public/uploads/"
