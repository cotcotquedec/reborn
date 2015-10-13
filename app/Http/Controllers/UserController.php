<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Models\Db;
use Polliwogs;
use Models\Business\User;
use Request;

class UserController extends Controller
{


    public function home()
    {
        return view('home');
    }

    public function getIndex()
    {
        $table = new Polliwogs\UserTable();

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
        $form->addLabel('name', 'Nom');
        $form->addCheckbox('is_active', 'Actif?');
        $form->addCheckbox('is_contributor', 'Contributeur?');
        $form->addCheckbox('is_admin', 'Admin?');
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
