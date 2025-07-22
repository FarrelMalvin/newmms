<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MonitorServices extends Command
{
    protected $signature = 'service:monitor';
    protected $description = 'Monitor and complete services that should be finished';

    public function handle()
    {
        // Find services in progress that started more than 2 hours ago
        $overdueServices = Service::where('status', 'pros')
            ->where('started_at', '<=', now()->subHours(2))
            ->get();

        foreach ($overdueServices as $service) {
            $service->status = 'fin';
            $service->finished_at = now();
            $service->save();
            
            Log::warning("Auto-completed overdue service: {$service->id_service}");
            $this->info("Completed overdue service: {$service->id_service}");
        }

        $this->info("Monitoring completed. Fixed {$overdueServices->count()} overdue services.");
        return 0;
    }
}