<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <link rel="icon" href="favicon.ico">

    <title>Reborn</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ elixir('main.css') }}" rel="stylesheet">

</head>

<body>

<div class="container">
    {!! Form::open(['class' => 'form-signin']) !!}
    <h2 class="form-signin-heading">Reborn</h2>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label for="inputEmail" class="sr-only">Email address</label>
    {!! Form::text('username', '' , ['placeholder' => 'Identifiant', 'class' => 'form-control', 'autofocus', 'required']) !!}
    <label for="inputPassword" class="sr-only">Password</label>
    {!! Form::password('password', ['placeholder' => 'Mot de passe', 'class' => 'form-control', 'required']) !!}

    {!! Form::submit('Connexion', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
    {!! Form::close() !!}
</div>
<!-- /container -->
</body>
</html>