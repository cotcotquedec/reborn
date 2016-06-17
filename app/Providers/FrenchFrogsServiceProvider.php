<?php namespace App\Providers;

use Illuminate\Mail;
use FrenchFrogs;

/**
 *
 *
 */

/**
 * Class FrenchFrogsServiceProvider
 * @package App\Providers
 */
class FrenchFrogsServiceProvider  extends \FrenchFrogs\Core\FrenchFrogsServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
       parent::register();
    }



    public function boot()
    {
      parent::boot();
    }
}