<?php namespace Polliwogs;

use FrenchFrogs\Polliwog\Table;
use Models\Db;

class UserTable extends Table\Table\Table
{

    public function init()
    {
        $query = Db\User\User::query();
        $this->setSource($query);
        $this->useDefaultPanel()->getPanel()->setTitle('Utilisateurs');
        $this->addText('name', 'Nom');
        $this->addText('email', 'Email');
        $this->addBoolean('is_active', 'Actif?');
        $this->addBoolean('is_contributor', 'Contributeur?');
        $this->addBoolean('is_admin', 'Admin?');
        $this->addButton('edit', 'Edition',  action_url('UserController','anyEdit', ['user' => '%s']), ['user_id'])->enableRemote();
        $this->enableDatatable();
    }
}