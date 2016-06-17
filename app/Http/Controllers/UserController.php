<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use FrenchFrogs\Acl\Http\Controllers\AclController;
use Models\Business\User;

/**
 * Class UserController
 *
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    use AclController;


    /**
     * Overload constructor to configure ACL trait
     *
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user_permission = User::PERMISSION_USER;
    }


    public function home()
    {

        $data = \query('analytics_realtime',
            [
                raw('CONCAT(HOUR(created_at), ":", ROUND(FLOOR(minute(created_at) / 15)) *15) as time'),
                raw('ROUND(AVG(hdn_active_users)) as hdn_user'),
                raw('ROUND(AVG(gnr_active_users)) as gnr_user')
            ])
        ->groupBy(raw('HOUR(created_at), ROUND(FLOOR(minute(created_at) / 15)) *15'))
        ->where('created_at', '>', raw('CURDATE()'))
        ->orderBy('created_at')
        ->get();


        $realtime = ['time' => [], 'hdn_user' => [], 'gnr_user' => []];
        foreach($data as $row) {
            foreach($row as $k => $v) {
                if (empty($realtime[$k])) {
                    $realtime[$k] = [];
                }
                $realtime[$k][] = $v;
            }
        }

        return view('home', compact('realtime'));
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function postParameter($id)
    {
        \ruler()->check(
            $this->user_permission,
            ['id' => 'exists:user,user_id'],
            ['id' => $uuid = f($id, 'uuid')]
        );

        // Recuperation du model
        $user = \FrenchFrogs\Models\Business\User::get($uuid);

        $form = \form()->enableRemote();
        $form->setLegend('Paramètres : ' . $user->getModel()->name);
        $form->addTitle('Twitter');
        $groups = \query('twitter_group', [raw('HEX(twitter_group_id) as twitter_group_id'),'name'])
            ->orderBy('name')
            ->pluck('name', 'twitter_group_id');
        $form->addSelect('twitter_group_id', 'Groupe', $groups, false)
            ->setPlaceholder()
            ->setDescription('Groupe Twitter par défaut');
        $form->addSelectRemote('twitter_account_id', 'Compte', action_url(TwitterController::class, 'getAccount'), 3, false)
            ->setDescription('Compte twitter par défaut');
        $form->addSubmit('Enregistrer');

        // enregistrement
        if (\request()->has('Enregistrer')) {
            $form->valid(\request()->all());
            if ($form->isValid()) {
                $data = $form->getFilteredAliasValues();
                try {
                    $user->setParameters($data);
                    \js()->success()->closeRemoteModal()->reloadDataTable();
                } catch(\Exception $e) {
                    \js()->error($e->getMessage());
                }
            }
        } else {
            $form->populate($user->getParameters());
        }

        return response()->modal($form);
    }
}
