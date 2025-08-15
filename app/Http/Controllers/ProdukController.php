<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class ProdukController extends Controller
{
    /**
     * Helper method to get correct image path
     */
    private function getImagePath($path)
    {
        return ImageHelper::getImageUrl($path);
    }

    /**
     * Helper method to check if image exists
     */
    private function imageExists($path)
    {
        return ImageHelper::imageExists($path);
    }

    /**
     * Clear all product-related caches
     */
    private function clearProductCaches()
    {
        // Clear specific product caches
        cache()->forget('all_produk');
        cache()->forget('api_produk');
        cache()->forget('featured_products');
        
        // Clear welcome page cache by pattern (more efficient)
        $keys = cache()->get('cache_keys', []);
        foreach ($keys as $key) {
            if (strpos($key, 'welcome_products_v') === 0) {
                cache()->forget($key);
            }
        }
        
        // Clear view cache for product pages only
        \Artisan::call('view:clear');
    }

    public function create()
    {
        return view('produk'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $path = $request->file('gambar')->store('uploads/featured', 'public');

        $produk = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->gambar_produk = $this->getImagePath($path); 
        $produk->deskripsi = $request->deskripsi;
        $produk->kategori = $request->kategori;
        $produk->save();
        
        // Clear product caches after adding new product
        $this->clearProductCaches();
        
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function index()
    {
        // Clear cache untuk memastikan data terbaru
        cache()->forget('all_produk');
        
        // Ambil semua produk tanpa cache untuk debugging
        $produk = Produk::all();
        
        // Default ke admin
        return view('admin-produk', compact('produk'));
    }

    public function customerIndex()
    {
        // Clear semua cache produk
        cache()->forget('api_produk');
        cache()->forget('all_produk');
        
        // Ambil semua produk untuk customer
        $produk = Produk::all();
        
        // Set header untuk mencegah browser cache
        $response = response()->view('product-customer', compact('produk'));
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');
        
        return $response;
    }

    public function getProduk()
    {
        try {
            // Clear cache dan ambil data fresh
            cache()->forget('api_produk');
            $produk = Produk::all();
            
            return response()->json([
                'message' => 'Produk sukses diambil',
                'produk' => $produk
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeProduk(Request $request)
    {
        try {
            $request->validate([
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|integer',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $produk = new Produk();
            $produk->nama_produk = $request->nama_produk;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->deskripsi = $request->deskripsi;
            $produk->kategori = $request->kategori;

            if ($request->hasFile('gambar')) {
                $produk->gambar_produk = ImageHelper::getStoragePath($request->file('gambar'), 'uploads/produk');
            }

            $produk->save();

            // Clear all product caches after adding new product
            $this->clearProductCaches();

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'produk' => $produk
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProduk(Request $request, $id)
    {
        try {
            $produk = Produk::find($id);
            if (!$produk) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|integer',
                'deskripsi' => 'required|string',
                'kategori' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $produk->nama_produk = $request->nama_produk;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->deskripsi = $request->deskripsi;
            $produk->kategori = $request->kategori;

            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($produk->gambar_produk) {
                    ImageHelper::deleteImage($produk->gambar_produk);
                }
                $produk->gambar_produk = ImageHelper::getStoragePath($request->file('gambar'), 'uploads/produk');
            }

            $produk->save();

            // Clear all product caches after updating product
            $this->clearProductCaches();

            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'produk' => $produk
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduk($id)
    {
        try {
            $produk = Produk::find($id);
            if (!$produk) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            // Delete image if exists
            if ($produk->gambar_produk) {
                ImageHelper::deleteImage($produk->gambar_produk);
            }

            $produk->delete();

            // Clear all product caches after deleting product
            $this->clearProductCaches();

            return response()->json([
                'message' => 'Produk berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showProduk($id)
    {
        try {
            $produk = Produk::find($id);
            if (!$produk) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Produk ditemukan',
                'produk' => $produk
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}