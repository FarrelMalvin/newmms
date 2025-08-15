<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Auto-complete services setiap 5 menit
        $schedule->command('services:auto-complete')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->runInBackground();

        // Clean logs setiap 5 menit (lebih agresif untuk 5 menit)
        $schedule->command('logs:clean --days=3 --size=25')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->runInBackground();

        // Optimasi Laravel setiap hari jam 2 pagi
        $schedule->command('optimize')
                 ->dailyAt('02:00')
                 ->withoutOverlapping()
                 ->runInBackground();

        // Clear cache setiap hari jam 3 pagi
        $schedule->command('cache:clear')
                 ->dailyAt('03:00')
                 ->withoutOverlapping()
                 ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 