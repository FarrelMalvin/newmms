<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
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
        $produk->gambar_produk = 'storage/' . $path; 
        $produk->deskripsi = $request->deskripsi;
        $produk->kategori = $request->kategori;
        $produk->save();
        
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function index()
    {
        $produk = Produk::all();
        // Jika request ke /product-customer, tampilkan view customer
        if (request()->is('product-customer')) {
            return view('product-customer', compact('produk'));
        }
        // Jika request ke /customer/product, juga tampilkan view customer
        if (request()->is('customer/product')) {
            return view('product-customer', compact('produk'));
        }
        // Default ke admin
        return view('admin-produk', compact('produk'));
    }

    public function getProduk()
    {
        try {
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
                $path = $request->file('gambar')->store('uploads/produk', 'public');
                $produk->gambar_produk = $path;
            }

            $produk->save();

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
                    Storage::disk('public')->delete($produk->gambar_produk);
                }
                $path = $request->file('gambar')->store('uploads/produk', 'public');
                $produk->gambar_produk = $path;
            }

            $produk->save();

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
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            $produk->delete();

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