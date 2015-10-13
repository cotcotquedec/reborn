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
        $query = Db\User\User::query();
        $table = table($query)->paginate(\Input::all());
        $table->useDefaultPanel()->getPanel()->setTitle('Utilisateurs');
        $table->addText('name', 'Nom');
        $table->addText('email', 'Email');
        $table->addBoolean('is_active', 'Actif?');
        $table->addBoolean('is_contributor', 'Contributeur?');
        $table->addBoolean('is_admin', 'Admin?');
        $table->addButton('edit', 'Edition',  action_url(static::class,'anyEdit', ['user' => '%s']), ['user_id'])->enableRemote();
        $table->enableDatatable();

        $table = new \Polliwog\User();
        return view('phoenix.user.index', compact('table'));

        return view('user.index', compact('table'));
    }

    /**
     * Edit a user
     *
     * @param $id
     * @return mixed
     */
    public function anyEdit($id)
    {
        // verification paramètre
        if (!User::exists($id)) {
            abort('404', 'Cette utilisateur n\'existe pas');
        }
        // Récuperation du model
        $user = User::get($id);
        // Formulaire
        $form = form()->enableRemote();
        $form->setLegend('Utilisateur : ' .$user->getModel()->name);
        $form->addLabel('email', 'Email');
        $form->addText('name', 'Nom');
        $form->addSubmit('Enregistrer');
        // maj info
        $form->populate($user->toArray());
        // enregistrement
        if (Request::has('Enregistrer')) {
            $form->valid(Request::all());
            if ($form->isValid()) {
                $data = $form->getFilteredValues();
                try {
                    \DB::transaction(function () use ($user, $data) {
                        $user->save($data);
                    });
                    js()->success()->closeRemoteModal()->reloadDataTable();
                } catch(\Exception $e) {
                    js()->error($e->getMessage());
                }
            }
        }
        return response()->modal($form);
    }
}
