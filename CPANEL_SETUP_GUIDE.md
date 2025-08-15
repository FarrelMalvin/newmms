# 🚀 cPanel Setup Guide - MMS Project

## 📋 LANGKAH-LANGKAH DEPLOYMENT CPANEL

### **1. Upload Files**
```
✅ Upload semua folder ke public_html
✅ Pastikan struktur folder benar
✅ Upload fix_cpanel_cache.sh
```

### **2. Import Database**
```
✅ Export MySQL dari local
✅ Import ke cPanel phpMyAdmin
✅ Pastikan semua tabel ter-import
```

### **3. Setup .env File**
```bash
# Buat file .env di public_html
APP_NAME="MMS Project"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### **4. Jalankan Script Setup**
```bash
# Di cPanel Terminal/SSH
cd public_html
chmod +x fix_cpanel_cache.sh
./fix_cpanel_cache.sh
```

### **5. Manual cPanel Steps (WAJIB)**

#### **A. File Manager - Create Symlink**
1. Buka **cPanel > File Manager**
2. Masuk ke folder **public_html**
3. **Create symlink**:
   - Name: `storage`
   - Target: `../storage/app/public`
4. **Set permissions** 755 untuk semua folder

#### **B. MultiPHP Manager**
1. Buka **cPanel > Software > MultiPHP Manager**
2. Set **PHP version** ke 8.1 atau 8.2
3. Klik **Save**

#### **C. PHP Selector**
1. Buka **cPanel > Software > PHP Selector**
2. Enable extensions:
   - ✅ fileinfo
   - ✅ gd
   - ✅ mbstring
   - ✅ openssl
   - ✅ pdo_mysql
   - ✅ zip
3. Klik **Save**

#### **D. Apache Configuration**
1. Buka **cPanel > Software > MultiPHP INI Editor**
2. Tambahkan:
   ```ini
   memory_limit = 256M
   max_execution_time = 300
   upload_max_filesize = 10M
   post_max_size = 10M
   ```
3. Klik **Save**

### **6. Test Website**
```
✅ Akses https://yourdomain.com
✅ Test login admin
✅ Test upload produk
✅ Test tampilan gambar
✅ Test data updates
```

### **7. Image Handling**

#### **A. Upload Images ke cPanel:**
```bash
# 1. Upload folder storage/app/public/uploads/ ke cPanel
# 2. Pastikan struktur folder:
public_html/storage/app/public/uploads/
├── produk/
│   ├── image1.jpg
│   ├── image2.png
│   └── ...
└── featured/
    └── ...
```

#### **B. Set Image Permissions:**
```bash
# Di Terminal cPanel
cd public_html
chmod -R 755 storage/app/public/uploads/
chmod -R 644 storage/app/public/uploads/produk/*
chmod -R 644 storage/app/public/uploads/featured/*
```

#### **C. Test Image Access:**
```bash
# Test apakah gambar bisa diakses
curl -I https://yourdomain.com/storage/uploads/produk/image1.jpg
# Harus return 200 OK
```

### **8. Troubleshooting**

#### **Jika Gambar Tidak Muncul:**
```bash
# Di Terminal
cd public_html
php artisan storage:link
chmod -R 755 storage/
chmod -R 755 public/storage/
chmod -R 755 storage/app/public/uploads/
```

#### **Jika Data Tidak Update:**
```bash
# Di Terminal
php artisan cache:clear-all --force
```

#### **Jika Error 500:**
1. Cek **error logs** di cPanel
2. Pastikan **PHP version** 8.1+
3. Pastikan **extensions** enabled
4. Cek **file permissions** 755

### **8. Security Checklist**
```
✅ APP_DEBUG=false di .env
✅ File permissions 755
✅ Symlink storage dibuat
✅ Database credentials benar
✅ SSL certificate aktif
```

### **9. Performance Optimization**
```
✅ Enable OPcache di PHP
✅ Set memory_limit 256M
✅ Enable gzip compression
✅ Optimize images sebelum upload
```

---
**Note:** Setelah setup selesai, sistem akan auto-clear cache saat CRUD data.
