<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use FrenchFrogs\Table\Renderer\Csv;
use Models\Acl;

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
            'u.email',
            raw('CONCAT(firstname, " ", lastname) as fullname'),
            raw('ROUND(amount/100,2) as amount'),
            raw('amount IS NOT NULL as paid'),
            'v.value as voucher',
//            'access_forum',
//            'access_jobmaker_way',
            'registred_at',
            'last_login'
        ])
            ->leftJoin('payment as p',function($join) {
                $join->on('p.user_id', '=', 'u.id')->where('p.status', '=', 'succeeded');
            })
            ->leftJoin('voucher_code as v', 'p.voucher_code_id','=','v.id')
            ->orderBy('email')
            ->orderBy('username');

        $table = \table($query);
        $table->setConstructor(static::class, __FUNCTION__)->enableRemote()->enableDatatable();
        $table->useDefaultPanel('Liste des Utilisateurs')->getPanel();

        $table->addText('fullname', 'Nom')->setStrainerText('username');
        $table->addText('email', 'Mail')->setStrainerText('email');
        $table->addBoolean('paid', 'Payant?')->setOrder('paid')->setStrainerBoolean('paid');
//        $table->addText('voucher', 'Promo')->setOrder('v.value')->setStrainerText('v.value');
//        $table->addNumber('amount', 'Payé', 2)->setOrder('amount');
//        $table->addBoolean('access_jobmaker_way', 'Accès Way?')->setOrder('access_jobmaker_way')->setStrainerBoolean('access_jobmaker_way');
//        $table->addBoolean('access_forum', 'Accès Forum?')->setOrder('access_forum')->setStrainerBoolean('access_forum');
        $table->addDate('last_login', 'Dern. visite')->setOrder('last_login');
        $table->addDate('registred_at', 'Inscrit le')->setOrder('registred_at');

        $table->setRenderer(new Csv());



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
       return view('basic', ['title' => 'Programmateur', 'content' => static::jobmaker()]);
    }
}
