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
        $products = Produk::all();
        $testimonials = Testimoni::with('pengguna')->where('menyoroti', 'true')->get();
        $news = Berita::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('products', 'testimonials', 'news'));
    }
} 