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
        $form->addCheckbox('permission', 'Droits', ['is_active' => 'Actif', 'is_contributor' => 'Contributeur', 'is_admin' => 'Admin']);
        $form->addSubmit('Enregistrer');


        // maj info
        $populate = $user->toArray();
        $populate['permission'] = [];
        if ($populate['is_active']) {
            $populate['permission'][] = 'is_active';
        }

        if ($populate['is_contributor']) {
            $populate['permission'][] = 'is_contributor';
        }

        if ($populate['is_admin']) {
            $populate['permission'][] = 'is_admin';
        }

        $form->populate($populate);


        // enregistrement
        if (Request::has('Enregistrer')) {
            $form->valid(Request::all());
            if ($form->isValid()) {
                $data = $form->getFilteredValues();
                try {
                    $data['is_active'] = array_search('is_active', $data['permission']) !== false;
                    $data['is_contributor'] = array_search('is_contributor', $data['permission']) !== false;
                    $data['is_admin'] = array_search('is_admin', $data['permission']) !== false;
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
