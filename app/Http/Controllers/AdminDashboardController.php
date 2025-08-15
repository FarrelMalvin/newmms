<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Berita;
use App\Models\Produk;
use App\Models\Service;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Optimasi: Gunakan cache untuk count queries
        $testimoniCount = cache()->remember('testimoni_count', 300, function() {
            return Testimoni::count();
        });
        
        $produkCount = cache()->remember('produk_count', 300, function() {
            return Produk::count();
        });
        
        $serviceCount = cache()->remember('service_count', 300, function() {
            return Service::count();
        });
        
        $beritaCount = cache()->remember('berita_count', 300, function() {
            return Berita::count();
        });

        // Optimasi: Tambah limit untuk recent data
        $recentTestimoni = Testimoni::with(['pengguna', 'service'])
            ->orderBy('id_testimoni', 'desc')
            ->limit(5)
            ->get();
        
        $recentProduk = Produk::orderBy('id_produk', 'desc')
            ->limit(5)
            ->get();
        
        $idCabang = Auth::user()->adminDetail->id_cabang ?? null;
        if (!$idCabang) {
            return back()->with('error', 'Admin does not have a branch assigned. Please complete admin data.');
        }
        
        $recentServices = Service::with('pengguna')
            ->where('id_cabang', $idCabang)
            ->orderBy('id_service', 'desc')
            ->limit(10)
            ->get();
        
        $recentBerita = Berita::orderBy('id_berita', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin-dashboard', compact(
            'testimoniCount',
            'produkCount', 
            'serviceCount',
            'beritaCount',
            'recentTestimoni',
            'recentProduk',
            'recentServices',
            'recentBerita'
        ));
    }

    public function getBerita($id) {
    try {
        $berita = Berita::find($id);
        
        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'berita' => $berita
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching berita: ' . $e->getMessage()
        ], 500);
    }
}

    
public function editBerita(Request $request, $id) {
    try {
        // Add debugging
        Log::info('Edit berita request data:', [
            'all_data' => $request->all(),
            'has_file' => $request->hasFile('foto')
        ]);

        $validated = $request->validate([
            'judul_berita' => 'required|string|max:255',
            'berita_judul' => 'nullable|string|max:255',
            'berita_deskripsi' => 'required|string|max:500',
            'berita_konten' => 'nullable|string|max:2000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        $berita = Berita::find($id);
        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Map form fields to database columns correctly
        $berita->judul_berita = $request->judul_berita;
        $berita->judul = $request->berita_judul;
        $berita->deskripsi = $request->berita_deskripsi;
        $berita->konten = $request->berita_konten;

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($berita->foto && Storage::disk('public')->exists($berita->foto)) {
                Storage::disk('public')->delete($berita->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('berita', $filename, 'public');
            $berita->foto = $path;
        }

        $berita->save();

        return response()->json([
            'success' => true,
            'message' => 'Berita sukses diperbarui',
            'berita' => $berita
        ]);
    } catch (ValidationException $e) {
        Log::error('Validation failed in edit berita:', [
            'errors' => $e->errors(),
            'request_data' => $request->except(['foto'])
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (Exception $e) {
        Log::error('Error updating berita:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui berita',
            'error' => $e->getMessage()
        ], 500);
    }
}
}