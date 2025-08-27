<?php

namespace Modules\Klinik\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your module.
     *
     * @var array
     */
    protected $commands = [
        \Modules\Klinik\Console\Commands\SyncKfaDrugsCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan sinkronisasi KFA-Drugs setiap minggu pada hari Senin jam 2 pagi
        $schedule->command('klinik:sync-kfa-drugs --threshold=75')
                 ->weeklyOn(1, '02:00')
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->runInBackground()
                 ->emailOutputOnFailure(config('app.admin_email', 'admin@example.com'));

        // Jalankan sinkronisasi untuk drugs yang belum sync setiap hari jam 3 pagi
        $schedule->command('klinik:sync-kfa-drugs --threshold=70 --limit=100')
                 ->dailyAt('03:00')
                 ->withoutOverlapping()
                 ->onOneServer()
                 ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}