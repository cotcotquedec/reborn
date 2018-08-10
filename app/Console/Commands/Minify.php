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

        // CSS
        $this->info(__FUNCTION__ . ' : CSS');
        $css = css()
            ->setTargetPath('build')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.1.2/collection/icon/icon.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/flat/blue.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css')
            ->styleFile('https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/skin-' . env('ADMINLTE_SKIN', 'black') . '.min.css')
//            ->styleFile('/adminlte/bower_components/bootstrap/dist/css/bootstrap.css')
//            ->styleFile('/adminlte/bower_components/bootstrap/dist/css/bootstrap-theme.css')
//            ->styleFile('/frenchfrogs/plugins/font-awesome/css/font-awesome.min.css')
//            ->styleFile('/frenchfrogs/plugins/ionicons/ionicons.min.css')
//            ->styleFile('/adminlte/plugins/iCheck/square/blue.css')
//            ->styleFile('/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css')
//            ->styleFile('/adminlte/bower_components/select2/dist/css/select2.css')
//            ->styleFile('/adminlte/dist/css/skins/skin-' . env('ADMINLTE_SKIN', 'black') . '.min.css')
//            ->styleFile('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')
//            ->styleFile('/adminlte/dist/css/AdminLTE.min.css')
//            ->styleFile('/frenchfrogs/plugins/toastr/toastr.min.css')
//            ->styleFile('/frenchfrogs/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css')
            ->styleFile('/frenchfrogs/dist/css/frenchfrogs.css')
            ->styleFile('/main.css');
        config('app.minify') && $css->enableMinify();
        cache()->forever(__FUNCTION__ . '.css', $css->minify());
        css()->clear();

        // JS
        $this->info(__FUNCTION__ . ' : JS');
        $js = js()
            ->setTargetPath('build')
//            ->file('/adminlte/bower_components/jquery/dist/jquery.js')
//            ->file('/adminlte/bower_components/bootstrap/dist/js/bootstrap.js')
//            ->file('/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.js')
//            ->file('/adminlte/bower_components/fastclick/lib/fastclick.js')
//            ->file('/adminlte/plugins/iCheck/icheck.min.js')
//            ->file('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')
//            ->file('/adminlte/bower_components/select2/dist/js/select2.full.js')
//            ->file('/frenchfrogs/plugins/jquery-form/jquery.form.min.js')
//            ->file('/frenchfrogs/plugins/toastr/toastr.min.js')
//            ->file('/frenchfrogs/plugins/bootstrap-switch/js/bootstrap-switch.min.js')
//            ->file('/adminlte/bower_components/datatables.net/js/jquery.dataTables.js')
//            ->file('/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.js')
//            ->file('/frenchfrogs/plugins/datatables/dataTables.buttons.min.js')
//            ->file('/frenchfrogs/plugins/datatables/buttons.bootstrap.min.js')


            ->file('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.fr.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/fr.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js')
            ->file('https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js')
            ->file('https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js')
            ->file('https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js')
            ->file('/adminlte/dist/js/adminlte.js')
            ->file('/frenchfrogs.js')
            ->file('/main.js');

        config('app.minify') && $js->enableMinify();
        cache()->forever(__FUNCTION__ . '.js', $js->minify());
        js()->clear();
    }
}