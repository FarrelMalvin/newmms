# 🚀 Deployment Guide - Image Handling

## Masalah Gambar Tidak Muncul di Hosting

### 1. **Symlink Storage (WAJIB)**
```bash
# Jalankan di server hosting
php artisan storage:link
```

### 2. **Permission Folder (WAJIB)**
```bash
# Set permission untuk folder storage
chmod -R 755 storage/
chmod -R 755 public/storage/
chmod -R 755 bootstrap/cache/
```

### 3. **Struktur Folder yang Benar**
```
public/
├── storage/          # Symlink ke storage/app/public/
└── images/           # Static images

storage/
└── app/
    └── public/
        └── uploads/
            ├── produk/     # Product images
            └── featured/   # Featured images
```

### 4. **Cek Path Gambar di Database**
```sql
-- Pastikan path di database sudah benar
SELECT id_produk, nama_produk, gambar_produk FROM produk;
```

**Path yang benar:**
- ✅ `storage/uploads/produk/filename.jpg`
- ❌ `uploads/produk/filename.jpg`
- ❌ `/storage/uploads/produk/filename.jpg`

### 5. **Troubleshooting**

#### A. Cek Symlink
```bash
ls -la public/ | grep storage
# Harus ada: storage -> ../storage/app/public
```

#### B. Cek File Exists
```bash
# Test apakah file ada
ls -la public/storage/uploads/produk/
```

#### C. Cek Permission
```bash
# Test apakah bisa diakses
curl -I https://yourdomain.com/storage/uploads/produk/filename.jpg
```

### 6. **Fallback Image System**
Sistem sudah diupdate dengan fallback:
- Jika gambar tidak ada → UI Avatar
- Jika gambar error → UI Avatar
- Jika path kosong → UI Avatar

### 7. **cPanel Specific**
Jika menggunakan cPanel:
1. File Manager → public_html
2. Buat symlink manual: `storage` → `../storage/app/public`
3. Set permission 755 untuk semua folder

### 8. **VPS/Dedicated Server**
```bash
# Nginx config
location /storage {
    alias /path/to/your/project/public/storage;
    try_files $uri $uri/ =404;
}

# Apache .htaccess (sudah ada di public/.htaccess)
```

### 9. **Testing**
```bash
# Test upload gambar baru
# Test tampilan di frontend
# Test tampilan di admin panel
```

### 10. **Common Issues & Solutions**

| Issue | Solution |
|-------|----------|
| 403 Forbidden | Set permission 755 |
| 404 Not Found | Cek symlink & path |
| Broken Image | Cek file exists & fallback |
| Upload Failed | Cek folder permission |

### 11. **Emergency Fix**
Jika gambar masih tidak muncul:
1. Upload ulang gambar via admin panel
2. Pastikan symlink sudah benar
3. Clear cache: `php artisan cache:clear`
4. Restart web server

---
**Note:** Sistem sudah diupdate dengan robust image handling yang akan menampilkan fallback image jika gambar asli tidak ditemukan.
