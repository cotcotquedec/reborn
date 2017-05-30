<?php

namespace App\Http\Controllers;

use FrenchFrogs\Core\FrenchFrogsController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,FrenchFrogsController {
        FrenchFrogsController::validate insteadof ValidatesRequests;
    }
}
