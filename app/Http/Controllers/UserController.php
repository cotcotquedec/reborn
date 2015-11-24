<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Models\Db;
use Polliwogs;
use Models\Business\User;
use Request;

use FrenchFrogs\Form\Element\Button;

class UserController extends Controller
{

    /**
     *
     *
     * @return \FrenchFrogs\Table\Table\Table
     */
    static function table()
    {
        $query = \DB::table('user')->addSelect(
            [
                \DB::raw('HEX(user_id) as user_id'),
                'name',
                'email',
                'is_active',
                'is_contributor',
                'is_admin'
            ]
        );
        $table = table()->setSource($query);
        $table->useDefaultPanel()->getPanel()->setTitle('Utilisateurs');


        $table = table($query);
        $table->setConstructor(__METHOD__)->enableRemote()->enableDatatable();
        $table->useDefaultPanel('Liste des utilisateurs');
        $table->addText('name', 'Nom');
        $table->addText('email', 'Email');
        $table->addBoolean('is_active', 'Actif?');
        $table->addBoolean('is_contributor', 'Contributeur?');
        $table->addBoolean('is_admin', 'Admin?');
        $table->setSearch('email');

        $container = $table->addContainer('action', 'Actions')->setWidth('80');
//        $container->addButton('permission', 'Permissions', action_url(static::class,'anyPermission', ['user' => '%s']), 'user_id')->enableRemote()->icon('fa fa-gavel');
        $container->addButtonEdit(action_url(static::class,'anyEdit', ['user' => '%s']), 'user_id');
        $container->addButtonDelete(action_url(static::class,'anyDelete', ['user' => '%s']), 'user_id');

        return $table;
    }


    /**
     * Main home
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Liste of users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $table = static::table();
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
        ruler()->check(
            null,
            ['id' => 'exists:user,user_id'],
            ['id' => \Uuid::import($id)->bytes]
        );

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

    /**
     * delete a command
     *
     * @param $id
     * @return mixed
     */
    public function anyDelete($id)
    {
        ruler()->check(
            null,
            ['id' => 'exists:user,user_id'],
            ['id' => \Uuid::import($id)->bytes]
        );

        // Récuperation du model
        $user = User::get($id);

        /**@var Modal $modal */
        $modal = modal(null, 'Etes vous sûr de vouloir supprimer : <b>' . $user->getModel()->name.'</b>' );
        $button = (new Button('yes', 'Supprimer !'))
            ->setOptionAsDanger()
            ->enableCallback()
            ->addAttribute('href',  request()->url() . '?delete=1');

        $modal->appendAction($button);

        // enregistrement
        if (Request::has('delete')) {
            try {
                /** @var User $user */
                \DB::transaction(function () use ($user, $id) {
                    $user->disable();
                });
                js()->success()->closeRemoteModal()->reloadDataTable();
            } catch(\Exception $e) {
                js()->error($e->getMessage());
            }

            return js();
        }

        return response()->modal($modal);
    }

}
