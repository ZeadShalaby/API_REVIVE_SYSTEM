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
        $schedule->command('revive:expire')->daily();

        //! Mailcode expire after 30 second everyThirtySeconds
        //todo call the name of command to run code after 24 hours //
        $schedule->command('mailCode:expire')->everyThirtySeconds();

        //! check machine work after 1 hour ->hourly()
        //todo call the name of command to run code every day at 1.00 clock ->dailyAt('1:00'), hourly//
        $schedule->command('machine:checkwork')->dailyAt('1:00');

        //! check Barter its End or not after daily
        //todo call the name of command to run code every day , hourly//
        $schedule->command('app:check-barter')->everyTenSeconds();

        //! clear column of total carbonfotprint from table machine ,to restart again from begineing
        //todo call the name of command to run code every month//
        // ? if i want at year from now : ->yearlyOn(now()->month, now()->day, now()->hour, now()->minute);
        $schedule->command('machine:percentage')->monthlyOn(now()->day, now()->hour . ':' . now()->minute);
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
