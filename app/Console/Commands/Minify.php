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
            ->styleFile('/adminlte/bootstrap/css/bootstrap.min.css')
            ->styleFile('/frenchfrogs/plugins/font-awesome/css/font-awesome.min.css')
            ->styleFile('/frenchfrogs/plugins/ionicons/ionicons.min.css')
            ->styleFile('/adminlte/plugins/iCheck/square/blue.css')
            ->styleFile('/adminlte/plugins/datatables/dataTables.bootstrap.css')
            ->styleFile('/adminlte/plugins/select2/select2.min.css')
            ->styleFile('/adminlte/dist/css/skins/skin-' . env('ADMINLTE_SKIN', 'black') . '.min.css')
            ->styleFile('/adminlte/plugins/datepicker/datepicker3.css')
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
            ->file('/adminlte/plugins/jQuery/jquery-2.2.3.min.js')
            ->file('/adminlte/bootstrap/js/bootstrap.min.js')
            ->file('/adminlte/plugins/slimScroll/jquery.slimscroll.min.js')
            ->file('/adminlte/plugins/fastclick/fastclick.js')
            ->file('/adminlte/plugins/iCheck/icheck.min.js')
            ->file('/adminlte/plugins/datepicker/bootstrap-datepicker.js')
            ->file('/adminlte/plugins/select2/select2.full.min.js')
            ->file('/frenchfrogs/plugins/jquery-form/jquery.form.min.js')
            ->file('/frenchfrogs/plugins/toastr/toastr.min.js')
            ->file('/frenchfrogs/plugins/bootstrap-switch/js/bootstrap-switch.min.js')
            ->file('/adminlte/plugins/datatables/jquery.dataTables.js')
            ->file('/adminlte/plugins/datatables/dataTables.bootstrap.js')
            ->file('/frenchfrogs/plugins/datatables/dataTables.buttons.min.js')
            ->file('/frenchfrogs/plugins/datatables/buttons.bootstrap.min.js')
            ->file('/frenchfrogs/dist/js/fnFilterOnReturn.js')
            ->file('/frenchfrogs/dist/js/fnFilterColumns.js')
            ->file('/adminlte/dist/js/app.min.js')
            ->file('/frenchfrogs/dist/js/frenchfrogs.js')
            ->file('/main.js');

        is_debug() || $js->enableMinify();
        Cache::forever(__FUNCTION__ . '.js', $js->minify());
        js()->clear();
    }
}