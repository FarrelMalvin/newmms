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
    protected $description = 'Auto-complete services that have been in progress for more than 2 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    { 
        $now = now();
        $cutoffTime = $now->subHours(2);

        // Optimasi: Gunakan chunk untuk mengurangi memory usage
        $completedCount = 0;
        
        Service::where('status', 'pros')
            ->whereNotNull('started_at')
            ->where('started_at', '<=', $cutoffTime)
            ->chunk(100, function ($services) use ($now, &$completedCount) {
                foreach ($services as $service) {
                    $service->status = 'fin';
                    $service->finished_at = $now;
                    $service->completion_notified = false;
                    $service->testimonial_eligible = true;
                    $service->save();
                    
                    $completedCount++;
                }
            });
            
        // Optimasi: Hanya log jika ada service yang di-complete
        if ($completedCount > 0) {
            Log::info("[Scheduler-5min] Total {$completedCount} services completed automatically");
        }
        // Log hanya sekali per jam jika tidak ada service yang di-complete
        else {
            $lastLogKey = 'scheduler_no_services_logged_' . date('Y-m-d-H');
            if (!cache()->has($lastLogKey)) {
                Log::info("[Scheduler-5min] No services to complete");
                cache()->put($lastLogKey, true, 3600); // 1 hour
            }
        }
    
        return 0;
    }
}