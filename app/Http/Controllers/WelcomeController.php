<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Models\Berita;

class WelcomeController extends Controller
{
    public function index()
    {
        // Smart cache strategy: cache dengan key yang berubah saat ada produk baru
        $cacheKey = 'welcome_products_v' . Produk::max('id_produk') . '_' . Produk::count();
        
        // Track cache keys for efficient clearing
        $cacheKeys = cache()->get('cache_keys', []);
        if (!in_array($cacheKey, $cacheKeys)) {
            $cacheKeys[] = $cacheKey;
            cache()->put('cache_keys', $cacheKeys, 86400); // 24 jam
        }
        
        $products = cache()->remember($cacheKey, 3600, function() { // 1 jam cache
            return Produk::orderBy('id_produk', 'desc')->limit(8)->get();
        });
        
        // Cache untuk testimonial dan berita tetap ada karena jarang berubah
        $testimonials = cache()->remember('welcome_testimonials', 300, function() {
            return Testimoni::with('pengguna')
                ->where('menyoroti', 'true')
                ->limit(6)
                ->get();
        });
        
        $news = cache()->remember('welcome_news', 300, function() {
            return Berita::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        });
        
        // Set response dengan cache control yang lebih optimal
        $response = response()->view('welcome', compact('products', 'testimonials', 'news'));
        $response->header('Cache-Control', 'public, max-age=300'); // 5 menit browser cache
        $response->header('ETag', md5($cacheKey)); // ETag untuk conditional requests
        
        return $response;
    }
} 