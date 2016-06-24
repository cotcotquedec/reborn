<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use FrenchFrogs\Table\Renderer\Csv;
use FrenchFrogs\Table\Table\Table;
use Models\Acl;
use Models\Db\Deprecated\FosUser;

/**
 * Class UserController
 *
 *
 * @package App\Http\Controllers
 */
class JobmakerController extends Controller
{

    /**
     * Liste des jobmakers
     *
     * @return \FrenchFrogs\Table\Table\Table
     */
    static public function jobmaker()
    {
        $query = \query('fos_user as u',[
            'u.id',
            'u.email',
            raw('CONCAT(firstname, " ", lastname) as fullname'),
            raw('ROUND(amount/100,2) as amount'),
            raw('amount IS NOT NULL as paid'),
            'v.value as voucher',
            'access_forum',
            'access_jobmaker_way',
            'locked',
            'registred_at',
            'last_login'
        ])
            ->leftJoin('payment as p',function($join) {
                $join->on('p.user_id', '=', 'u.id')->where('p.status', '=', 'succeeded');
            })
            ->leftJoin('voucher_code as v', 'p.voucher_code_id','=','v.id')
            ->orderBy('email')
            ->orderBy('username');

        // TABLE
        $table = \table($query);
        $table->setConstructor(static::class, __FUNCTION__)->enableRemote()->enableDatatable();
        $table->useDefaultPanel('Liste des Utilisateurs')->getPanel();
        $table->setIdField('id');

        // COLMUMN
        $table->addText('fullname', 'Nom')->setStrainerText('username');
        $table->addText('email', 'Mail')->setStrainerText('email');
        $table->addBoolean('paid', 'Payant?')->setOrder('paid')->setStrainerBoolean('paid');
        $table->addDate('last_login', 'Dern. visite')
            ->setWidth('152px')
            ->setOrder('last_login')
            ->setStrainerDateRange('last_login');

        $table->addDate('registred_at', 'Inscrit le')
            ->setWidth('152px')
            ->setOrder('registred_at')
            ->setStrainerDateRange('registred_at');

        $table->addRemoteBoolean('access_jobmaker_way', 'Accès Way?',  function($id, $value = null) {
            FosUser::find($id)->update(['access_jobmaker_way' => raw('!access_jobmaker_way')]);
            return \js()->reloadDataTable()->success();
        })->setStrainerBoolean('access_jobmaker_way');

        $table->addRemoteBoolean('access_forum', 'Accès Forum?',  function($id, $value = null) {
            FosUser::find($id)->update(['access_forum' => raw('!access_forum')]);
            return \js()->reloadDataTable()->success();
        })->setStrainerBoolean('access_forum');

        $table->addRemoteBoolean('locked', 'Bloqué?',  function($id, $value = null) {
            FosUser::find($id)->update(['locked' => raw('!locked')]);
            return \js()->reloadDataTable()->success();
        })->setStrainerBoolean('access_forum');

        $table->addButtonEdit(action_url(static::class, 'postJobmaker', '%s'), 'id');

        $table->addDatatableButtonExport();
        return $table;
    }


    /**
     * Page d'accueil pour la gestion des jobmakers
     *
     * @return mixed
     */
    public function getIndex()
    {
       \ruler()->check(Acl::PERMISSION_JOBMAKER_USER);
       return view('basic', ['title' => 'Utilisateurs', 'content' => static::jobmaker()]);
    }


    /**
     * @param $id
     */
    public function postJobmaker($id)
    {
        \ruler()->check(
            Acl::PERMISSION_JOBMAKER_USER,
            ['id' => 'exists:fos_user,id'],
            ['id' => $id]
        );

        // MODEL
        $model = FosUser::find($id);

        // FORM
        $form = \form()->enableRemote();
        $form->setLegend('Jobmaker : ' . $model->username);

        $form->addText('username', 'Username');
        $form->addEmail('email', 'Email');

        $form->addSeparator();
        $form->addTitle('Accès');
        $form->addBoolean('access_jobmaker_way', 'Way?');
        $form->addBoolean('access_forum', 'Forum?');
        $form->addBoolean('locked', 'Bloqué');
//        $form->addBoolean('expired', 'Expiré');
//        $form->addDate('expired_at', 'Date expiration', false);

        $form->addSeparator();
        $form->addTitle('Civilité');
        $form->addText('firstname', 'Prénom', false);
        $form->addText('lastname', 'Nom', false);
        $form->addDate('birthdate', 'Naissance', false);
        $form->addText('city', 'Ville', false);
        $form->addText('country', 'Pays', false);
        $form->addSubmit('Enregistrer');


        // TRAITEMENT
        if (request()->has('Enregistrer')) {
            $form->valid(request()->all());
            if ($form->isValid()) {
                $data = $form->getFilteredValues();
                try {
                    $model->update($data);
                    \js()->success()->closeRemoteModal()->reloadDataTable();
                } catch(\Exception $e) {
                    \js()->error($e->getMessage());
                }
            }
        } else {
            $form->populate($model->toArray());
        }

        return response()->modal($form);
    }
}
