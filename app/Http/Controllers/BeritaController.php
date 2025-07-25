<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BeritaController extends Controller
{
    public function index() {
        return view('admin-berita');
    }

    public function getBerita() {
        try {
            $berita = Berita::orderBy('created_at', 'desc')->get();
            return response()->json([
                'message' => 'Berita sukses diambil',
                'berita' => $berita 
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil berita',
                'error' => $e->getMessage()
            ], 500); // Fix: Use status code as second parameter
        }
    }

    public function getBeritaById($id) {
        try {
            $berita = Berita::find($id);
            if ($berita) {
                return response()->json([
                    'success' => true,
                    'berita' => $berita
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404); // Fix: Use status code as second parameter
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil berita',
                'error' => $e->getMessage()
            ], 500); // Fix: Use status code as second parameter
        }
    }

    public function postBerita(Request $request) {
        try {
            // Add detailed logging before validation
            Log::info('Incoming request data:', [
                'judul_berita' => $request->judul_berita,
                'deskripsi' => $request->deskripsi,
                'konten' => $request->konten,
                'judul' => $request->judul,
                'has_file' => $request->hasFile('foto'),
                'all_keys' => array_keys($request->all())
            ]);

            // Increase file size limit to match frontend
            $validated = $request->validate([
                'judul_berita' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'konten' => 'nullable|string',
                'judul' => 'nullable|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000' // Changed to 5mb
            ]);

            $berita = new Berita();
            $berita->judul_berita = $request->judul_berita;
            $berita->deskripsi = $request->deskripsi;
            $berita->konten = $request->konten;
            $berita->judul = $request->judul;

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                Log::info('File upload details:', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError()
                ]);
                
                if (!$file->isValid()) {
                    throw new Exception('File upload failed: ' . $file->getErrorMessage());
                }
                
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('berita', $filename, 'public');
                
                if (!$path) {
                    throw new Exception('Failed to store uploaded file');
                }
                
                $berita->foto = $path;
            }

            $berita->save();

            return response()->json([
                'message' => 'Berita sukses dibuat',
                'berita' => $berita
            ], 201);

        } catch (ValidationException $e) {
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['foto'])
            ]);
            
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'debug_info' => [
                    'received_fields' => array_keys($request->all()),
                    'has_file' => $request->hasFile('foto')
                ]
            ], 422);
        } catch (Exception $e) {
            Log::error('Error creating berita: ' . $e->getMessage(), [
                'request_data' => $request->except(['foto']),
                'has_file' => $request->hasFile('foto'),
                'file_info' => $request->hasFile('foto') ? [
                    'name' => $request->file('foto')->getClientOriginalName(),
                    'size' => $request->file('foto')->getSize(),
                    'mime' => $request->file('foto')->getMimeType(),
                    'error' => $request->file('foto')->getError()
                ] : null
            ]);
            
            return response()->json([
                'message' => 'Gagal membuat berita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editBerita(Request $request, $id) {
        try {
            $validated = $request->validate([
                'judul_berita' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'konten' => 'nullable|string',
                'judul' => 'nullable|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000' // Changed to 5mb
            ]);

            $berita = Berita::find($id);
            if (!$berita) {
                return response()->json([
                    'message' => 'Berita tidak ditemukan'
                ], 404); // Fix: Use status code as second parameter
            }

            $berita->judul_berita = $request->judul_berita;
            $berita->deskripsi = $request->deskripsi;
            $berita->konten = $request->konten;
            $berita->judul = $request->judul;

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
                'message' => 'Berita sukses diperbarui',
                'berita' => $berita
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui berita',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function deleteBerita($id) {
        try {
            $berita = Berita::find($id);
            if ($berita) {
                // Delete associated file if exists
                if ($berita->foto && Storage::disk('public')->exists($berita->foto)) {
                    Storage::disk('public')->delete($berita->foto);
                }
                
                $berita->delete();
                return response()->json([
                    'message' => 'Berita sukses dihapus'
                ]);
            } else {
                return response()->json([
                    'message' => 'Berita tidak ditemukan'
                ], 404); // Fix: Use status code as second parameter
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus berita',
                'error' => $e->getMessage()
            ], 500); // Fix: Use status code as second parameter
        }
    }
}