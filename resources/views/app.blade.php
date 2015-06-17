<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <link rel="icon" href="/favicon.ico">
    <title>Reborn</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ elixir('main.css') }}" rel="stylesheet">

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">Reborn</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('file-list') }}">Fichiers</a></li>
                <li><a href="#series">Series</a></li>
                <li><a href="#films">Films</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#monprofil">Mon profil</a></li>
                <li><a href="/auth/logout">Déconnexion</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    @yield('content')
</div>
<!-- /container -->

<script src="{{ elixir('main.js') }}"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('select[placeholder]').each(function() {
            $(this).prepend('<option value="" disabled selected>'+ $(this).attr('placeholder') +'</option>');
        });

        $('.colorbox-me').colorbox();
    })
</script>

@yield('js-inline')
</body>
</html>
