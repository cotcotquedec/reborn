<?php

namespace App\Console;

use App\Console\Commands;
use FrenchFrogs\Acl\Console\AclTablesCommand;
use FrenchFrogs\Acl\Console\ScheduleTablesCommand;
use FrenchFrogs\Scheduler\Console\SchedulerKernel;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use FrenchFrogs\Models\Db;
use Illuminate\Support\Facades\Schema;

class Kernel extends ConsoleKernel
{
    use SchedulerKernel;


    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\Permission::class,
        Commands\PermissionRemove::class,
        Commands\Minify::class,
        Commands\Upgrade::class,


        // initialisation
        \FrenchFrogs\Acl\Console\AclTableCommand::class,
        \FrenchFrogs\Acl\Console\CreateUserCommand::class,
        \FrenchFrogs\Acl\Console\ChangeUserPasswordCommand::class,
        \FrenchFrogs\Scheduler\Console\ScheduleTableCommand::class,
        \FrenchFrogs\Reference\Console\ReferenceTableCommand::class,
        \FrenchFrogs\Reference\Console\ReferenceBuildCommand::class,


        // en dev
        \FrenchFrogs\Maker\Console\ControllerCreateCommand::class,
        \FrenchFrogs\Maker\Console\ControllerActionCreateCommand::class,
        Commands\Permission::class,
    ];

    public function handle($input, $output = null)
    {
        return $this->hasSchedule() ? $this->handleSchedule($input, $output) :  parent::handle($input, $output);
    }


    public function terminate($input, $status)
    {

        if ($this->hasSchedule()) {
            $this->terminateSchedule($input, $status);
        }
        parent::terminate($input, $status); // TODO: Change the autogenerated stub
    }
}
