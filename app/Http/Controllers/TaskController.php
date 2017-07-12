<?php

namespace App\Http\Controllers;

use App\Models\Db\References;

class TaskController extends Controller
{


    /**
     *
     *
     *
     */
    public function getIndex()
    {
        return $this->basic('Téléchargements', $this->tableIndex());
    }

    public function tableIndex()
    {

        // QUERY
        $query = \query('downloads as d', [
            raw('HEX(uuid) as uuid'),
            'r.name as status_name',
            'url',
            'errors',
            'd.created_at',
            'd.completed_at',
        ])->join('references as r', 'r.rid', 'status_rid');


        // TABLE
        $table = \table($query);
        $table->setConstructor(static::class, __FUNCTION__)->enableRemote()->enableDatatable();
        $panel = $table->useDefaultPanel('')->getPanel();


        // COLMUMN
        $table->addText('status_name', 'Status')->setStrainerSelect(References::where('collection', 'downloads.status')->pluck('name', 'rid'), 'd.status_rid');
        $table->addPre('url', 'URL')->setWidth(400)->setStrainerText('url');
        $table->addPre('errors', 'Erreur')->setWidth(400);
        $table->addDatetime('created_at', 'Ajouté le')->setOrder('d.created_at');
        $table->addDatetime('completed_at', 'Fini le')->setOrder('d.completed_at');

        // ACTION
        $action = $table->addContainer('action', 'Action')->setWidth('80')->right();
//        $action->addButtonEdit(action_url(static::class, 'postContact', [$uuid->hex, '%s']), 'uuid');
        return $table;

    }

}
