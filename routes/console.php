<?php

use App\MyService;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use App\Console\Commands\FinishCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(FinishCommand::class)
    ->everySecond();

// Schedule::call(FinishCommand::class)
//     ->everySecond();



   