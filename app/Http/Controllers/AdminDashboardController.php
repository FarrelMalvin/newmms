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
        $testimoniCount = Testimoni::count();
        $produkCount = Produk::count() ?? 0;
        $serviceCount = Service::count() ?? 0;
        $beritaCount = Berita::count() ?? 0;

        $recentTestimoni = Testimoni::with(['pengguna', 'service'])
            ->orderBy('id_testimoni', 'desc')
            ->get();
        
        // Get recent products
        $recentProduk = Produk::orderBy('id_produk', 'desc')
            ->get();
        
        // Get recent services/bookings
        $idCabang = Auth::user()->adminDetail->id_cabang ?? null;
        if (!$idCabang) {
            return back()->with('error', 'Admin belum memiliki cabang. Silakan lengkapi data admin.');
        }
        $recentServices = Service::with('pengguna')
            ->where('id_cabang', $idCabang)
            ->orderBy('id_service', 'desc')
            ->get();
        
        // Get recent news
        $recentBerita = Berita::orderBy('id_berita', 'desc')
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