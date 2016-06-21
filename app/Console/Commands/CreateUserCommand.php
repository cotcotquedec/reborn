<?php

namespace App\Console\Commands;

use FrenchFrogs\Acl\Acl;
use FrenchFrogs\Models\Business\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create 
                                {email : Email de l\'utilisateur} 
                                {--name= : Nom complet de l\'utilisateur}
                                {--interface= : Interface de l\'utilisateur}
                                {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Création d'un utilisateur";

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

        // email
        $email = $this->argument('email');

        // génération automatique de l'email
        $password = str_random(8);

        // nom complet
        $name = null;
        if ($this->hasOption('name')) {
            $name = $this->option('name');
        }

        // interface
        $interface = $this->hasArgument('interface') ? $this->argument('interface') : Acl::INTERFACE_DEFAULT;

        // on valide que l'utilisateur n'existe pas déjà
        $user = \FrenchFrogs\Models\Db\User\User::firstOrNew([
            'email' => $email,
            'user_interface_id' => $interface
        ]);

        // si l'utilisateur existe déjà on coupe le script
        if ($user->exists) {
            throw new \Exception('L\'utilisateur "' . $email . '"" pour l\'interface "' . $interface. '"" existe déjà');
        }

        // création de l'utilisateur
        $user->password = bcrypt($password);
        $user->name = $name;
        $user->save();

        // affichage du mot de passe
        $this->info('Le mot de passe généré est : ' . $password );

        // gestion de l'admin
        if ($this->option('admin')) {
            $permission = \FrenchFrogs\Models\Db\User\Permission::where('user_interface_id', $interface)->pluck('user_permission_id');
            User::get($user->getKey())->setPermissions($permission->toArray());
        }
    }
}
