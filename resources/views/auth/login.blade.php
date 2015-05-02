<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Alliwant</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="account-container">

    <div class="content clearfix">

        {!! Form::open() !!}

            <h1>Alliwant</h1>

            <div class="login-fields">

                <p>Saisissez vos identifiants</p>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="field">
                    {!! Form::label('username', 'Identifiant') !!}
                    {!! Form::text('username', '' , ['placeholder' => 'Identifiant', 'class' => 'login username-field']) !!}
                </div> <!-- /field -->

                <div class="field">
                    {!! Form::label('password', 'Mot de passe') !!}
                    {!! Form::password('password', ['placeholder' => 'Mot de passe', 'class' => 'login password-field']) !!}
                </div> <!-- /password -->
            </div> <!-- /login-fields -->
            <div class="login-actions">
                {!! Form::submit('Connexion', ['class' => 'button btn btn-success btn-large']) !!}
            </div> <!-- .actions -->
        {!! Form::close() !!}
    </div> <!-- /content -->
</div> <!-- /account-container -->

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/signin.js"></script>

</body>
</html>