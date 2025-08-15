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
            // Optimasi: Tambah limit dan cache
            $allTestimoni = cache()->remember('all_testimoni', 300, function() {
                return Testimoni::with('pengguna', 'service')
                    ->orderBy('created_at', 'desc') // Gunakan created_at setelah timestamps ditambahkan
                    ->limit(50) // Tambah limit
                    ->get();
            });
            
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
                    'message' => 'User not found'
                ], 401);
            }

            // Ambil semua service finished milik user yang belum ada testimoni
            $services = Service::where('id_pengguna', $user->id_pengguna)
                ->where('status', 'fin')
                ->whereDoesntHave('testimoni', function($q) use ($user) {
                    $q->where('id_pengguna', $user->id_pengguna);
                })
                ->orderBy('finished_at', 'desc')
                ->get();

            if ($services->isEmpty()) {
                return response()->json([
                    'message' => 'No completed services found for this user that have not been reviewed'
                ], 404);
            }

            // Kembalikan semua service yang eligible
            return response()->json([
                'eligible_services' => $services->map(function($service) {
                    return [
                        'id_service' => $service->id_service,
                        'tanggal' => $service->tanggal,
                        'keluhan' => $service->keluhan,
                        'status' => $service->status,
                        'finished_at' => $service->finished_at
                    ];
                }),
                'message' => 'Valid services found'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to get services',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // For admin view page
    public function index() {
        try {
            // Optimasi: Tambah limit
            $testimoni = Testimoni::with('pengguna', 'service')
                ->orderBy('created_at', 'desc') // Gunakan created_at setelah timestamps ditambahkan
                ->limit(50) // Tambah limit
                ->get();
            
            return view('admin-testimoni', compact('testimoni'));
            
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load testimonials: ' . $e->getMessage());
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
            ], [
                'id_pengguna.required' => 'User ID is required.',
                'id_pengguna.exists' => 'User not found.',
                'id_service.required' => 'Service ID is required.',
                'id_service.integer' => 'Service ID must be a valid number.',
                'isi_testimoni.required' => 'Testimonial content is required.',
                'isi_testimoni.string' => 'Testimonial content must be text.',
                'isi_testimoni.max' => 'Testimonial content cannot exceed 1000 characters.',
                'menyoroti.required' => 'Highlight selection is required.',
                'menyoroti.in' => 'Invalid highlight selection.',
                'rating_bintang.required' => 'Star rating is required.',
                'rating_bintang.integer' => 'Star rating must be a number.',
                'rating_bintang.min' => 'Star rating must be at least 1.',
                'rating_bintang.max' => 'Star rating cannot exceed 5.'
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
            $service = Service::where('id_service', $request->id_service)->first();
            if (!$service) {
                return response()->json([
                    'message' => 'Service not found.'
                ], 404);
            }

            // Cek apakah service sudah selesai (status = 'fin')
            if ($service->status !== 'fin') {
                return response()->json([
                    'message' => 'Testimonials can only be created for completed services.'
                ], 400);
            }

            // Cek apakah service milik pengguna yang bersangkutan
            if ($service->id_pengguna != $request->id_pengguna) {
                return response()->json([
                    'message' => 'You can only create testimonials for your own services.'
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
                'message' => 'Testimonial created successfully',
                'testimoni' => $testimoni
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create testimonial',
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