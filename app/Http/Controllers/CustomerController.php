<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Testimoni;

class CustomerController extends Controller
{
    public function checkCompletedServices()
    {
        $userId = Auth::id();
        
        // Get the most recent completed service that hasn't been notified
        $completedService = Service::where('id_pengguna', $userId)
            ->where('status', 'fin')
            ->where('completion_notified', false)
            ->whereNotNull('finished_at')
            ->with(['typeservice', 'cabang'])
            ->orderBy('finished_at', 'desc')
            ->first();
        
        if ($completedService) {
            return response()->json([
                'hasCompleted' => true,
                'service' => [
                    'id' => $completedService->id_service,
                    'service_name' => $completedService->typeservice->nama_service ?? 'Service',
                    'completed_at' => $completedService->finished_at->format('M d, Y H:i'),
                    'location' => $completedService->cabang->nama_cabang ?? 'Main Branch',
                    'date' => $completedService->tanggal
                ]
            ]);
        }
        
        return response()->json(['hasCompleted' => false]);
    }

    public function markServiceNotified(Service $service)
    {
        // Verify the service belongs to the authenticated user
        if ($service->id_pengguna !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $service->completion_notified = true;
        $service->notification_sent_at = now();
        $service->save();
        
        return response()->json(['success' => true]);
    }

    public function serviceHistory()
    {
        $userId = Auth::id();
        
        // Optimasi: Gunakan with() untuk eager loading dan load testimoni sekaligus
        $completedServices = Service::where('id_pengguna', $userId)
            ->where('status', 'fin')
            ->with(['typeservice', 'cabang', 'testimoni'])
            ->orderBy('finished_at', 'desc')
            ->limit(20) // Tambah limit
            ->get()
            ->map(function($service) use ($userId) {
                return [
                    'id' => $service->id_service,
                    'service_name' => $service->typeservice->nama_service ?? 'Service',
                    'completed_at' => $service->finished_at ? $service->finished_at->format('M d, Y H:i') : 'N/A',
                    'location' => $service->cabang->nama_cabang ?? 'Main Branch',
                    'date' => $service->tanggal,
                    'has_testimonial' => $service->testimoni->where('id_pengguna', $userId)->count() > 0
                ];
            });
        
        return response()->json([
            'services' => $completedServices
        ]);
    }

    public function testimonialHistory()
    {
        $userId = Auth::id();
        
        // Optimasi: Tambah limit dan gunakan created_at untuk ordering
        $testimonials = Testimoni::where('id_pengguna', $userId)
            ->with(['service.typeservice', 'service.cabang'])
            ->orderBy('created_at', 'desc') // Gunakan created_at setelah timestamps ditambahkan
            ->limit(20) // Tambah limit
            ->get()
            ->map(function($testimoni) {
                return [
                    'id' => $testimoni->id_testimoni,
                    'service_name' => $testimoni->service->typeservice->nama_service ?? 'Service',
                    'location' => $testimoni->service->cabang->nama_cabang ?? 'Main Branch',
                    'rating' => $testimoni->rating_bintang,
                    'message' => $testimoni->isi_testimoni,
                    'created_at' => $testimoni->created_at ? $testimoni->created_at->format('M d, Y H:i') : 'N/A',
                    'highlighted' => $testimoni->menyoroti
                ];
            });
        
        return response()->json([
            'testimonials' => $testimonials
        ]);
    }
}