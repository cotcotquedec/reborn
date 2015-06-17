var elixir = require('laravel-elixir');



/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

var components = '/../../components/';

elixir(function(mix) {
    mix .copy( './resources/components/fontawesome/fonts', 'public/fonts')
        .copy( './resources/components/jquery-colorbox/example1/images', 'public/build/images' )


        .scripts([  components + 'jquery/dist/jquery.min.js',
                    components + 'bootstrap/dist/js/bootstrap.min.js',
                    components + 'selectize/dist/js/standalone/selectize.js',
                    components + 'jquery-colorbox/jquery.colorbox-min.js',
                    components + 'jquery-colorbox/i18n/jquery.colorbox-fr.js',
                    'main.js'
                ], 'public/main.js')

        .styles([   components + 'bootstrap/dist/css/bootstrap.min.css',
                    components + 'fontawesome/css/font-awesome.min.css',
                    components + 'selectize/dist/css/selectize.bootstrap3.css',
                    components + 'jquery-colorbox/example1/colorbox.css',
                    'style.css'
            ], 'public/main.css')

        .version(['main.js', 'main.css']);
});
