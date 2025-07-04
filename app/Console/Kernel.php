<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\DeactivateExpiredRfids::class,
        \App\Console\Commands\DeleteOldVisits::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('rfids:deactivate-expired')
            ->dailyAt('03:00')
            ->timezone('Asia/Kuala_Lumpur')  // e.g. 'Asia/Kuala_Lumpur'
            ->environments(['production']);
        $schedule->command('visits:clean')->dailyAt('01:00');
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
