<?php

namespace App\Console;

use App\Console\Commands\CleanNonExistsFile;
use App\Console\Commands\Download;
use App\Console\Commands\Minify;
use App\Console\Commands\ScanMedia;
use App\Console\Commands\Test;
use FrenchFrogs\App\Console\CodeReferenceCommand;
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

        Test::class,
        Minify::class,
        ScanMedia::class,
        Download::class,
        CleanNonExistsFile::class,


        //FRENCHFROGS
        \FrenchFrogs\App\Console\AclTableCommand::class,
        \FrenchFrogs\App\Console\CreateUserCommand::class,
        \FrenchFrogs\App\Console\ChangeUserPasswordCommand::class,
//        \FrenchFrogs\App\Console\ScheduleTableCommand::class,
        \FrenchFrogs\App\Console\ReferenceTableCommand::class,
        \FrenchFrogs\App\Console\ReferenceBuildCommand::class,
//        \FrenchFrogs\App\Console\MailTableCommand::class,
//        \FrenchFrogs\App\Console\MailSendCommand::class,
        \FrenchFrogs\App\Console\MediaTableCommand::class,
//        \FrenchFrogs\App\Console\ContentTableCommand::class,


        // en dev
        \FrenchFrogs\App\Console\CodeControllerCommand::class,
        \FrenchFrogs\App\Console\CodeActionCommand::class,
        \FrenchFrogs\App\Console\CodeMailCommand::class,
        \FrenchFrogs\App\Console\CodePermissionCommand::class,
        CodeReferenceCommand::class,
        \FrenchFrogs\App\Console\CodeModelCommand::class,
        \FrenchFrogs\App\Console\ContentBuildCommand::class,
        \FrenchFrogs\App\Console\DevContentCommand::class,
        \FrenchFrogs\App\Console\CodeMigrationCommand::class,
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
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
