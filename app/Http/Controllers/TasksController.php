<?php

namespace App\Http\Controllers;

use App\Models\Db\References;

class TasksController extends Controller
{


    /**
     *
     *
     *
     */
    public function index()
    {
        return view('tasks');
    }


    public function downloads()
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
        $table = table($query);
        $table->enableRemote()->enableDatatable();
        $table->useDefaultPanel('Téléchargements')->getPanel();

        // COLMUMN
        $table->addText('status_name', 'Status')
            ->setStrainerSelect(References::where('collection', 'downloads.status')->pluck('name', 'rid'), 'd.status_rid');
        $table->addPre('url', 'URL')
            ->setWidth(300)
            ->setStrainerText('url');
        $table->addDatetime('created_at', 'Ajouté le')->setOrder('d.created_at');
        $table->addDatetime('completed_at', 'Fini le')->setOrder('d.completed_at');

        // DEFAULT
        if (request()->isMethod('GET')) {
            $table->getColumn('created_at')->order('desc');
        }

        return $table->processRequest($this->request());
    }

}
