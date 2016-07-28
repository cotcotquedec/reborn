<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cache;

class Minify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify js and css';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gestion de la page de login
     *
     */
    public function login()
    {
        $this->info(__FUNCTION__ . ' : CSS');
        $css = \css()
//            ->enableMinify()
            ->setTargetPath('build')
            ->styleFile('/adminlte/bootstrap/css/bootstrap.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css')
            ->styleFile('/adminlte/dist/css/AdminLTE.min.css')
            ->styleFile('/adminlte/plugins/iCheck/square/blue.css')
            ->minify();
        Cache::forever(__FUNCTION__ . '.css', $css);

        $this->info(__FUNCTION__ . ' : JS');
        $js = \js('mini_js')
//            ->enableMinify()
            ->setTargetPath('build')
            ->file('/adminlte/plugins/jQuery/jquery-2.2.3.min.js')
            ->file('/adminlte/bootstrap/js/bootstrap.min.js')
            ->file('/adminlte/plugins/iCheck/icheck.min.js')
            ->minify();

        Cache::forever(__FUNCTION__ . '.js', $js);
    }

    public function layout()
    {
        $this->info(__FUNCTION__ . ' : CSS');

        /*
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
         */
        $css = \css()
//            ->enableMinify()
            ->setTargetPath('build')
            ->styleFile('/adminlte/bootstrap/css/bootstrap.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css')
            ->styleFile('/adminlte/dist/css/AdminLTE.min.css')
            ->styleFile('/adminlte/plugins/iCheck/square/blue.css')
            ->styleFile('/adminlte/dist/css/skins/skin-'.env('ADMINLTE_SKIN', 'dark').'.min.css')
            ->minify();
        Cache::forever(__FUNCTION__ . '.css', $css);

        $this->info(__FUNCTION__ . ' : JS');
        $js = \js('mini_js')
//            ->enableMinify()
            ->setTargetPath('build')
            ->file('/adminlte/plugins/jQuery/jquery-2.2.3.min.js')
            ->file('/adminlte/bootstrap/js/bootstrap.min.js')
            ->file('/adminlte/plugins/slimScroll/jquery.slimscroll.min.js')
            ->file('/adminlte/plugins/fastclick/fastclick.js')
            ->file('/adminlte/plugins/fastclick/fastclick.js')
            ->file('/adminlte/plugins/iCheck/icheck.min.js')
            ->file('/adminlte/dist/js/app.min.js')
            ->minify();

        Cache::forever(__FUNCTION__ . '.js', $js);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->login();
        $this->layout();
    }
}