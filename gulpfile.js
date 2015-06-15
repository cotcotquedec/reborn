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

elixir(function(mix) {
    mix.copy( './resources/components/fontawesome/fonts', 'public/fonts' )

        .scripts([   '/../../components/jquery/dist/jquery.min.js',
                    '/../../components/bootstrap/dist/js/bootstrap.min.js',
                    '/../../components/selectize/dist/js/standalone/selectize.js'
                ], 'public/main.js')

        .styles([   '/../../components/bootstrap/dist/css/bootstrap.min.css',
                    '/../../components/fontawesome/css/font-awesome.min.css',
            '/../../components/selectize/dist/css/selectize.css',
            '/../../components/selectize/dist/css/selectize.bootstrap3.css',
                    'style.css'
            ], 'public/main.css')

        .version(['main.js', 'main.css'])

});
