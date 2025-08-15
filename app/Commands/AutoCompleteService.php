<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\Service;

class AutoCompleteService
{
    public function __invoke(Schedule $schedule)
    {
        $schedule->call(function () {
            $now = now();

            $services = Service::where('status', 'pros')
                ->whereNotNull('started_at')
                ->where('started_at', '<=', $now->subHours(2)) // Changed to 2 hours
                ->get();
                
            Log::info('[Scheduler] Ditemukan ' . $services->count() . ' service untuk diubah');
            foreach ($services as $service) {
                $service->status = 'fin';
                $service->finished_at = $now;
                $service->save();
                
                Log::info("[Scheduler] Service ID {$service->id_service} completed automatically");
            }
        })->everySecond()
          ->withoutOverlapping()
          ->runInBackground();
    }
}