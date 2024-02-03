<?php

namespace App\Console;

use App\Console\Commands\expiration;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //! column expire expire after 24 hour daily()
        // $schedule->command('inspire')->hourly(); //->everyTenSeconds();	daily()
        //todo call the name of command to run code after 24 hours //
        $schedule->command('revive:expire')->everyFiveSeconds();

        //! Mailcode expire after 30 second everyThirtySeconds
        //todo call the name of command to run code after 24 hours //
        $schedule->command('mailCode:expire')->everyFiveSeconds();

        //! check machine work after 1 hour ->hourly()
        //todo call the name of command to run code after 24 hours //
        $schedule->command('machine:checkwork')->everyFiveSeconds();
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
