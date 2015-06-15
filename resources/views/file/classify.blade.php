@extends('app')

@section('content')
    <div class="page-header">
        <h1>Trier</h1>

        <p class="alert alert-warning ">Avec ce formulaire, vous ranger les fichiers pour qu'ils soient conservés et accessibles via les univers "Séries" et "Films"</p>
    </div>


    <div class="row">

        <div class="col-sm-12">
            <h2>Informations</h2>
            <p class="well">
                <b>Fichier :</b> {{ $info['basename'] }}<br>
                <b>Taille :</b> {{ $info['size'] }} Mo<br>
                <b>Mime :</b> {{ $info['mime'] }}<br>
            </p>
        </div>

        <div class="col-sm-6">
            <h2>Serie</h2>

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'GET' ]) !!}

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

            <div class="form-group">
                {!! Form::label('tvshow', 'Serie', ['class' => 'col-sm-2 control-label']) !!}

                <div class="col-sm-10">
                    {!! Form::select('tvshow', $tvshow , null, ['class' => 'form-control selectize-me', 'placeholder' => 'Choisir la série']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('episode', 'Episode', ['class' => 'col-sm-2 control-label']) !!}

                <div class="col-sm-10">
                    {!! Form::select('episode', [] , null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group text-right">
                <div class="col-sm-4 col-sm-offset-8">
                    {!! Form::submit('Rechercher', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'search']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>

        <div class="col-sm-6">
            <h2>Film</h2>

            {!! Form::open(['class' => 'form-horizontal', 'method' => 'GET' ]) !!}

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

            <div class="form-group">
                {!! Form::label('query', 'Recherche', ['class' => 'col-sm-2 control-label']) !!}

                <div class="col-sm-10">
                    {!! Form::text('query', Input::get('query'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group text-right">
                <div class="col-sm-4 col-sm-offset-8">
                    {!! Form::submit('Rechercher', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'search']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>



    </div>


@endsection


@section('js-inline')

    <script>

        $(function () {
            $('#tvshow').selectize({
                create: true,
                sortField: 'text'
            });

            $('#tvshow').change(function(){

                console.log($(this).val());
            });


        })
    </script>

@endsection