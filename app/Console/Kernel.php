<?php

namespace pos2020\Console;

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
        // Commands\Inspire::class,
        \pos2020\Console\Commands\MstPlcbItem::class,
        \pos2020\Console\Commands\TransferNewSkusToNpl::class,
        \pos2020\Console\Commands\TrackNewSkus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('mstplcbitem:mstplcbitem_update')->dailyAt('23:08');
        
        $schedule->command('track:newskus')->dailyAt('04:00');
        $schedule->command('transfernewskus:npl')->dailyAt('05:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // $this->command('build {project}', function ($project) {
        //     $this->info('Building project...');
        // });
    }
}
