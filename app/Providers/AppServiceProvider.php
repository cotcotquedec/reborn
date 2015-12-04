<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Storage::extend('files', function($app, $config)
        {
            $client = new Local(storage_path('files'), LOCK_EX, Local::DISALLOW_LINKS,
                [   'file' =>
                    [
                        'public' => 0755,
                        'private' => 0700,
                    ],
                    'dir' => [
                        'public' => 0755,
                        'private' => 0700,
                    ]
                ]);

            return new Filesystem($client);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
