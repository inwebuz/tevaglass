<?php

namespace App\Console;

use App\Console\Commands\AtmosTokenUpdate;
use App\Console\Commands\ProcessProducts;
use App\Console\Commands\ProductsFeed;
use App\Console\Commands\SynchroPhotos;
use App\Console\Commands\SynchroSmartup;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command(SynchroPhotos::class)->everyFifteenMinutes();
        $schedule->command(ProcessProducts::class, ['price'])->hourly();
        $schedule->command(ProcessProducts::class, ['rating'])->twiceDaily(3, 15);
        $schedule->command(AtmosTokenUpdate::class)->everyThirtyMinutes();
        $schedule->command(ProductsFeed::class, ['hatchXml'])->twiceDaily(2, 14);
        // $schedule->command(ProcessProducts::class)->everyMinute();
        // $schedule->command(SynchroSmartup::class)->everyTwoHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
