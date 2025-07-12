<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function getTestimoni() {
        try {
            $testimoni = Testimoni::all();
            
            return response()->json([
                'message' => 'Testimoni sukses diambil',
                'testimoni' => $testimoni 
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
    
    public function store(Request $request) {
        try {
            $testimoni = new Testimoni();
            $testimoni->id_pengguna = $request->id_pengguna;
            $testimoni->id_service = $request->id_service; 
            $testimoni->isi_testimoni = $request->isi_testimoni; 
            $testimoni->menyoroti = $request->menyoroti; 
            $testimoni->save();
            
            return response()->json([
                'message' => 'Testimoni sukses dibuat',
                'testimoni' => $testimoni
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}