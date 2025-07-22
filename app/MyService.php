<?php

namespace App;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Concerns\InteractsWithIO;



class MyService
{
    /**
     * Create a new class instance.
     */
    public function __invoke()
    {
        logger()->info('Class MyService invoked');
        $now = Carbon::now();
        
        // Find services that have been in progress for more than 10 seconds
        $services = Service::where('status', 'pros')
            ->whereNotNull('started_at')
            ->where('started_at', '<=', $now->subSeconds(10))
            ->get();
            
        $completedCount = 0;
        
        Log::info('[Auto-Complete] Found ' . $services->count() . ' services to complete');
        
        foreach ($services as $service) {
            $service->update([
                'status' => 'fin', 
                'completed_at' => $now
            ]);
            
            $completedCount++;
            
            Log::info("[Auto-Complete] Service ID {$service->id} completed automatically");
        }
        
        
        if ($completedCount > 0) {
            Log::info("[Auto-Complete] Successfully completed {$completedCount} services");
        }
        
        return 0;
    }
}
 