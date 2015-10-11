<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Models\Db;

class UserController extends Controller
{


    public function home()
    {
        return view('home');
    }

    public function getIndex()
    {
        $query = Db\User\User::query();//join('user_phoenix as p', 'user.user_id', '=', 'p.user_id');
        $table = table($query)->paginate(\Input::all());
        $table->useDefaultPanel()->getPanel()->setTitle('Utilisateurs');
        $table->addText('name', 'Nom');
        $table->addText('email', 'Email');
//        $table->addText('loggedin_at', 'Dernière connexion');
//        $table->addButton('edit', 'Edition',  action_url(static::class,'anyEdit', ['user' => '%s']), ['user_id'])->enableRemote();
        return view('user.index', compact('table'));
    }

    public function anyEdit()
    {

//@todo
        return '@TODO';
    }
}
