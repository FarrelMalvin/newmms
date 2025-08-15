<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImageHelper
{
    /**
     * Get image URL with fallback
     */
    public static function getImageUrl($path, $fallback = null)
    {
        if (empty($path)) {
            return $fallback ?? self::getDefaultAvatar();
        }

        // If path already has http/https, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Add storage prefix if not present
        if (!str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }

        // Check if file exists
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Try alternative paths for hosting
        $alternativePaths = [
            $path,
            str_replace('storage/', '', $path),
            'uploads/' . basename($path),
            'images/' . basename($path)
        ];

        foreach ($alternativePaths as $altPath) {
            if (file_exists(public_path($altPath))) {
                return asset($altPath);
            }
        }

        return $fallback ?? self::getDefaultAvatar();
    }

    /**
     * Get product image URL
     */
    public static function getProductImageUrl($product, $size = 200)
    {
        if ($product && $product->gambar_produk) {
            $url = self::getImageUrl($product->gambar_produk);
            
            // If it's not a fallback URL, return it
            if (!str_contains($url, 'ui-avatars.com')) {
                return $url;
            }
        }

        // Return UI Avatar as fallback
        return self::getProductAvatar($product->nama_produk ?? 'Product', $size);
    }

    /**
     * Get berita image URL
     */
    public static function getBeritaImageUrl($berita, $fallback = null)
    {
        if ($berita && $berita->foto) {
            $url = self::getImageUrl($berita->foto);
            
            // If it's not a fallback URL, return it
            if (!str_contains($url, 'ui-avatars.com')) {
                return $url;
            }
        }

        // Return fallback image
        return $fallback ?? 'https://via.placeholder.com/400x220/FE8400/FFFFFF?text=No+Image';
    }

    /**
     * Get default avatar URL
     */
    public static function getDefaultAvatar()
    {
        return 'https://ui-avatars.com/api/?name=User&background=FE8400&color=ffffff&size=128';
    }

    /**
     * Get product avatar URL
     */
    public static function getProductAvatar($name, $size = 200)
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=FE8400&color=ffffff&size=' . $size . '&font-size=0.4';
    }

    /**
     * Check if image exists
     */
    public static function imageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        // Add storage prefix if not present
        if (!str_starts_with($path, 'storage/')) {
            $path = 'storage/' . $path;
        }

        return file_exists(public_path($path));
    }

    /**
     * Get storage path for saving
     */
    public static function getStoragePath($file, $folder = 'uploads/produk')
    {
        $path = $file->store($folder, 'public');
        return 'storage/' . $path;
    }

    /**
     * Delete image file
     */
    public static function deleteImage($path)
    {
        if (empty($path)) {
            return false;
        }

        // Remove storage prefix for deletion
        $storagePath = str_replace('storage/', '', $path);
        
        if (Storage::disk('public')->exists($storagePath)) {
            return Storage::disk('public')->delete($storagePath);
        }

        return false;
    }
}
