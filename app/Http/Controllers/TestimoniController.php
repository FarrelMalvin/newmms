<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function getTestimoni() {
        try {
            $testimoni = Testimoni::all();
            
            return response()->json([
                'message' => 'Testimoni retrieved successfully',
                'testimoni' => [$testimoni] // Replace with actual testimonials data
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
    
/*************  ✨ Windsurf Command ⭐  *************/
/*******  2bb01527-e6cf-486d-9db9-e54b78974ba0  *******/
    public function store(Request $request) {
        try {
            $testimoni = new Testimoni();
            $testimoni->id_pengguna = $request->id_pengguna;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->save();
            
            return response()->json([
                'message' => 'Testimoni created successfully',
                'testimoni' => $testimoni
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}