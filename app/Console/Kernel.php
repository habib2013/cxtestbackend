<?php

namespace App\Console;
use App\User;
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
        Commands\WordOfTheDay::class,
        Commands\AutoDebitCard::class,
        Commands\AutoCreditWallet::class,
        commands\CreditWallet::class,
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
        // $schedule->command('word:day')->everyMinute();
        // $schedule->command('autodebit:card')->dailyAt('13:00');
        // $schedule->command('autocredit:wallet')->dailyAt('13:00');
           $schedule->command('autodebit:card')->everyMinute();
        // $schedule->command('autocredit:wallet')->everyMinute();
        $schedule->command('credit:wallet')->everyMinute();
     
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
