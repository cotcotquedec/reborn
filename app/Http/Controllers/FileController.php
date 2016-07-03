<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Models\Acl;

/**
 */
class FileController extends Controller
{

    /**
     * @name Artisan
     * @generated 2016-07-03 09:26:05
     * @see php artisan ffmake:action
     */
    public function getIndex()
    {
        \ruler()->check(
            Acl::PERMISSION_FILE
        );


        return basic('_TITRE_', '_CONTENT_');
    }
}