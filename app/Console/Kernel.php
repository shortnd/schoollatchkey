<?php

namespace App\Console;

use App\Console\Commands\AddLateFee;
use App\Console\Commands\DailyChildCheckin;
use App\Console\Commands\SchoolInvitationClear;
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
        $schedule->command(DailyChildCheckin::class)->weekdays()->daily();
        $schedule->command(AddLateFee::class)->weekdays()
            ->between('18:00', '18:30')->everyTenMinutes();
        $schedule->command(SchoolInvitationClear::class)->daily();
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
