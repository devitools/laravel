<?php

declare(strict_types=1);

namespace Devitools\Console;

use Devitools\Persistence\Transaction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class Kernel
 *
 * @package Devitools\Console
 */
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
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        /** @noinspection PhpIncludeInspection */
        require base_path('routes/console.php');
    }

    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        parent::bootstrap();

         Transaction::start();
    }

    /**
     * Terminate the application.
     *
     * @param  InputInterface  $input
     * @param  int  $status
     * @return void
     */
    public function terminate($input, $status)
    {
        parent::terminate($input, $status);

        Transaction::finish($status);
    }
}
