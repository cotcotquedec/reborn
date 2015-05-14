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
    mix.scripts([   '/../../components/jquery/dist/jquery.min.js',
                    '/../../components/bootstrap/dist/js/bootstrap.min.js'
                ], 'public/main.js');

    mix.styles([   '/../../components/bootstrap/dist/css/bootstrap.min.css',
                    'style.css'
            ], 'public/main.css');

    mix.version(['main.js', 'main.css'])
});
