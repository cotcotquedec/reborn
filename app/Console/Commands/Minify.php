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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start CSS');
        $css = \css()
            ->enableMinify()
            ->setTargetPath('build')
            ->styleFile('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')
            ->styleFile('/conquer/plugins/font-awesome-4.5.0/css/font-awesome.min.css')
            ->styleFile('/conquer/plugins/simple-line-icons/simple-line-icons.min.css')
            ->styleFile('/conquer/plugins/bootstrap/css/bootstrap.min.css')
            ->styleFile('/conquer/plugins/uniform/css/uniform.default.css')
            ->styleFile('/conquer/plugins/select2/select2.css')
            ->styleFile('/conquer/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')
            ->styleFile('/conquer/plugins/bootstrap-toastr/toastr.min.css')
            ->styleFile('/conquer/plugins/bootstrap-datepicker/css/datepicker.css')
//            ->styleFile('/conquer/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')
            ->styleFile('/conquer/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')
            ->styleFile('/conquer/plugins/bootstrap-datetimepicker/css/datetimepicker.css')
            ->styleFile('/conquer/plugins/bootstrap-switch/css/bootstrap-switch.min.css')
            ->styleFile('/conquer/plugins/fancybox/source/jquery.fancybox.css')
            ->styleFile('/conquer/css/style-conquer.css')
            ->styleFile('/conquer/css/style.css')
            ->styleFile('/conquer/css/style-responsive.css')
            ->styleFile('/conquer/css/plugins.css')
            ->styleFile('/conquer/css/pages/tasks.css')
            ->styleFile('/conquer/css/themes/'. env('PHOENIX_THEME', 'default') .'.css')
            ->styleFile('/conquer/css/custom.css')
            ->styleFile('/assets/css/frenchfrogs.css')
            ->minify();

        Cache::forever('minify.css', $css);

        $this->info('Start Javascript');
        $js = \js('mini_js')
            //->enableMinify()
            ->setTargetPath('build')
            ->file('/conquer/plugins/jquery-1.11.0.min.js')
            ->file('/conquer/plugins/jquery-migrate-1.2.1.min.js')
            ->file('/conquer/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')
            ->file('/conquer/plugins/bootstrap/js/bootstrap.min.js')
            ->file('/conquer/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')
            ->file('/conquer/plugins/jquery-slimscroll/jquery.slimscroll.min.js')
            ->file('/conquer/plugins/jquery.blockui.min.js')
            ->file('/conquer/plugins/uniform/jquery.uniform.min.js')
            ->file('/conquer/plugins/select2/select2.min.js')
            ->file('/conquer/plugins/datatables/media/js/jquery.dataTables.min.js')
            ->file('/conquer/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')

            ->file('/conquer/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')
            ->file('/conquer/plugins/bootstrap-toastr/toastr.min.js')
            ->file('/conquer/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')
//            ->file('/conquer/plugins/bootstrap-daterangepicker/moment.min.js')
//            ->file('/conquer/plugins/bootstrap-daterangepicker/daterangepicker.js')
            ->file('/conquer/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')
            ->file('/conquer/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js')
            ->file('/conquer/plugins/bootstrap-switch/js/bootstrap-switch.min.js')
            ->file('/conquer/plugins/fancybox/source/jquery.fancybox.pack.js')
            ->file('/assets/js/jquery.form.min.js')
            ->file('/assets/js/Chart.min.js')
            ->file('/assets/js/frenchfrogs.js')
            ->file('/assets/js/fnFilterOnReturn.js')
            ->file('/assets/js/fnFilterColumns.js')
            ->file('/assets/js/dataTables.buttons.min.js')
            ->file('/assets/js/buttons.bootstrap.min.js')
            ->file('/conquer/scripts/app.js')
            ->minify();

        Cache::forever('minify.js', $js);
    }
}