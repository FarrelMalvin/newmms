<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use Carbon\Carbon;

class FinishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-complete services that have been in progress for more than 10 seconds';

    /**
     * Execute the console command.
     */
    public function handle()
    { 
        logger()->info('Auto-complete service command started');
        $now = now();

        $services = Service::where('status', 'pros')
            ->whereNotNull('started_at')
            ->where('started_at', '<=', $now->subSeconds(10)) 
            ->get();
            
        Log::info('[Scheduler] Ditemukan ' . $services->count() . ' service untuk diubah');
        
        foreach ($services as $service) {
            $service->status = 'fin';
            $service->finished_at = $now;
            $service->completion_notified = false; // Mark as needing notification
            $service->testimonial_eligible = true; // Mark as eligible for testimonial
            $service->save();
            
            Log::info("[Scheduler] Service ID {$service->id_service} completed automatically and marked for notification");
        }
    
        return 0;
    }
}