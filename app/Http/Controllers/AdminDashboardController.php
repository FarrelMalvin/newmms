<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Produk;
use App\Models\Service;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}