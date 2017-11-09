<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->web();
    }

    /**
     *
     * Gestion des asset
     *
     */
    public function web()
    {
        $this->info(__FUNCTION__ . ' : CSS');

        // CSS
        $css = \css()
            ->setTargetPath('build')
            ->styleFile('/adminlte/bower_components/bootstrap/dist/css/bootstrap.css')
            ->styleFile('/adminlte/bower_components/bootstrap/dist/css/bootstrap-theme.css')
            ->styleFile('/frenchfrogs/plugins/font-awesome/css/font-awesome.min.css')
            ->styleFile('/frenchfrogs/plugins/ionicons/ionicons.min.css')
            ->styleFile('/adminlte/plugins/iCheck/square/blue.css')
            ->styleFile('/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css')
            ->styleFile('/adminlte/bower_components/select2/dist/css/select2.css')
            ->styleFile('/adminlte/dist/css/skins/skin-' . env('ADMINLTE_SKIN', 'black') . '.min.css')
            ->styleFile('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')
            ->styleFile('/adminlte/dist/css/AdminLTE.min.css')
            ->styleFile('/frenchfrogs/plugins/toastr/toastr.min.css')
            ->styleFile('/frenchfrogs/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css')
            ->styleFile('/frenchfrogs/dist/css/frenchfrogs.css')
            ->styleFile('/main.css');

        is_debug() || $css->enableMinify();
        Cache::forever(__FUNCTION__ . '.css', $css->minify());
        \css()->clear();

        $this->info(__FUNCTION__ . ' : JS');
        $js = \js()
            ->setTargetPath('build')
            ->file('/adminlte/bower_components/jquery/dist/jquery.js')
            ->file('/adminlte/bower_components/bootstrap/dist/js/bootstrap.js')
            ->file('/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.js')
            ->file('/adminlte/bower_components/fastclick/lib/fastclick.js')
            ->file('/adminlte/plugins/iCheck/icheck.min.js')
            ->file('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')
            ->file('/adminlte/bower_components/select2/dist/js/select2.full.js')
            ->file('/frenchfrogs/plugins/jquery-form/jquery.form.min.js')
            ->file('/frenchfrogs/plugins/toastr/toastr.min.js')
            ->file('/frenchfrogs/plugins/bootstrap-switch/js/bootstrap-switch.min.js')
            ->file('/adminlte/bower_components/datatables.net/js/jquery.dataTables.js')
            ->file('/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.js')
            ->file('/frenchfrogs/plugins/datatables/dataTables.buttons.min.js')
            ->file('/frenchfrogs/plugins/datatables/buttons.bootstrap.min.js')
            ->file('/frenchfrogs/dist/js/fnFilterOnReturn.js')
            ->file('/frenchfrogs/dist/js/fnFilterColumns.js')
            ->file('/adminlte/dist/js/adminlte.js')
            ->file('/frenchfrogs/dist/js/frenchfrogs.js')
            ->file('/main.js');

        is_debug() || $js->enableMinify();
        Cache::forever(__FUNCTION__ . '.js', $js->minify());
        js()->clear();
    }
}