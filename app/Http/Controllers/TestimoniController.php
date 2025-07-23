<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    // For API endpoint
    public function getTestimoni() {
        try {
            $allTestimoni = Testimoni::with('pengguna', 'service')->get();
            
            return response()->json([
                'message' => 'Testimoni sukses diambil',
                'testimoni' => $allTestimoni 
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get valid service for current user
    public function getValidService() {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            // Get the latest finished service for this user
            $service = Service::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'fin') // Hanya service yang sudah selesai
                ->orderBy('id_service', 'desc')
                ->first();

            if (!$service) {
                return response()->json([
                    'message' => 'Tidak ada service yang sudah selesai untuk user ini'
                ], 404);
            }

            // Cek apakah sudah ada testimoni untuk service ini
            $existingTestimoni = Testimoni::where('id_service', $service->id_service)
                ->where('id_pengguna', $user->id_pengguna)
                ->first();

            if ($existingTestimoni) {
                return response()->json([
                    'message' => 'Anda sudah membuat testimoni untuk service ini'
                ], 400);
            }

            return response()->json([
                'id_service' => $service->id_service,
                'service_details' => [
                    'tanggal' => $service->tanggal,
                    'keluhan' => $service->keluhan,
                    'status' => $service->status,
                    'finished_at' => $service->finished_at
                ],
                'message' => 'Service yang valid ditemukan'
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mendapatkan service',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // For admin view page
    public function index() {
        try {
            $testimoni = Testimoni::with('pengguna', 'service')
                ->orderBy('id_testimoni', 'desc')
                ->get();
            
            return view('admin-testimoni', compact('testimoni'));
            
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mengambil testimoni: ' . $e->getMessage());
        }
    }
    
    public function postTestimoni(Request $request) {
        try {
            $request->validate([
                'id_pengguna' => 'required|exists:pengguna,id_pengguna',
                'id_service' => 'required|integer',
                'isi_testimoni' => 'required|string|max:1000',
                'menyoroti' => 'required|string|in:true,false',
                'rating_bintang' => 'required|integer|min:1|max:5'
            ]);

            // Cek apakah user sudah pernah mengisi testimoni untuk service ini
            $existing = Testimoni::where('id_pengguna', $request->id_pengguna)
                ->where('id_service', $request->id_service)
                ->first();
            if ($existing) {
                return response()->json([
                    'message' => 'You have already submitted a testimonial for this service.'
                ], 400);
            }

            // Validasi service harus ada dan status harus finished
            $service = \App\Models\Service::where('id_service', $request->id_service)->first();
            if (!$service) {
                return response()->json([
                    'message' => 'Service tidak ditemukan.'
                ], 404);
            }

            // Cek apakah service sudah selesai (status = 'fin')
            if ($service->status !== 'fin') {
                return response()->json([
                    'message' => 'Testimoni hanya dapat dibuat untuk service yang sudah selesai (status finished).'
                ], 400);
            }

            // Cek apakah service milik pengguna yang bersangkutan
            if ($service->id_pengguna != $request->id_pengguna) {
                return response()->json([
                    'message' => 'Anda hanya dapat membuat testimoni untuk service Anda sendiri.'
                ], 403);
            }

            $testimoni = new Testimoni();
            $testimoni->id_pengguna = $request->id_pengguna;
            $testimoni->id_service = $service->id_service; 
            $testimoni->isi_testimoni = $request->isi_testimoni; 
            $testimoni->menyoroti = $request->menyoroti == 'true' ? 'true' : 'false';
            $testimoni->rating_bintang = $request->rating_bintang;
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

    public function updateTestimoni(Request $request, $id) {
        try {
            $testimoni = Testimoni::find($id);
            if (!$testimoni) {
                return response()->json([
                    'message' => 'Testimoni tidak ditemukan'
                ], 404);
            }

            // Toggle highlight
            if ($request->has('highlight')) {
                $testimoni->menyoroti = $request->highlight === 'true' ? 'true' : 'false';
                $testimoni->save();
            }
            
            return response()->json([
                'message' => 'Testimoni sukses diupdate',
                'testimoni' => $testimoni
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteTestimoni($id) {
        try {
            $testimoni = Testimoni::find($id);
            if ($testimoni) {
                $testimoni->delete();
                return response()->json([
                    'message' => 'Testimoni sukses dihapus'
                ]);
            } else {
                return response()->json([
                    'message' => 'Testimoni tidak ditemukan'
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus testimoni',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}