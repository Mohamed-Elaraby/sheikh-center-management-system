<?php

namespace App\Console;

use App\Console\Commands\GetMoneySafeOpeningBalance;
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
        GetMoneySafeOpeningBalance::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('backup:clean')->everyMinute();
//        $schedule->command('backup:run --only-db') ->everyMinute();
        $schedule -> command('moneySafe:getOpeningBalance')->dailyAt('05:00')->timezone('Asia/Dubai');
//        $schedule -> command('moneySafe:getOpeningBalance')->everyMinute();
//         $schedule->command('inspire') ->hourly();
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
