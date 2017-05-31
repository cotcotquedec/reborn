<?php

namespace App\Http\Controllers;

use FrenchFrogs\Core\FrenchFrogsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,FrenchFrogsController {
        FrenchFrogsController::validate insteadof ValidatesRequests;
    }

    /**
     * Basic return
     *
     * @param $title
     * @param $content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basic($title, $content, $template = 'basic')
    {
        return view($template, compact('title', 'content', 'description'));
    }
}
