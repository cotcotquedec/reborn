<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use FrenchFrogs\Acl\Acl;
use FrenchFrogs\Models\Reference;
use FrenchFrogs\Laravel\Database\Schema\Blueprint;

class DevController extends Controller
{

    public function layout()
    {
        return view('dev', compact('form'));
    }


    public function script()
    {

        dd(\Ref::JOB_STATUS_ACTIVE);

        Reference::build();

        dd('OK');

        require_once app_path() . '/../vendor/frenchfrogs/reference/src/function.php';

        $reference = \ref('member.status', true)->pairs();

        dd($reference);

        return 'Are you happy with your script';
    }
}