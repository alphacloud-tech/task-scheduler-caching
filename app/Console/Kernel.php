<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('logs:clean-old')->everyTwoMinutes();

        // Clear the cache every hour
        $schedule->call(function () {
            // Invalidate the weather data cache
            Cache::forget('weather_data');
            // Add more cache keys to forget here if necessary
        })->hourly(); /// everyTwoMinutes
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}