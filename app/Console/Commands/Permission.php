<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Models\Db\User\User;

class Permission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission {user : email of the user} {permission : Permission ID to apply}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // validation declaration
        $validator = \Validator::make(
            [
                'user' => $user = $this->argument('user'),
                'permission' => $permission = $this->argument('permission')
            ],
            [
                'user' => 'required|exists:user,email',
                'permission' => 'required|exists:user_permission,user_permission_id'
            ]
        );

        // check if argument are valid
        if ($validator->fails()) {
            $this->error($validator->getMessageBag()->toJson());
            return;
        }

        // get user
        $user = User::where('email', $user)->first(['user_id']);

        /**@var \Models\Business\User $user*/
        \Models\Business\User::get($user->user_id)->addPermission($permission);
    }
}
