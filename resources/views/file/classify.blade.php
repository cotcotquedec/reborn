@extends('app')

@section('content')
    <div class="page-header">
        <h1>Trier</h1>

        <p class="alert alert-warning ">Avec ce formulaire, vous ranger les fichiers pour qu'ils soient conservés et accessibles via les univers "Séries" et "Films"</p>
    </div>


    <div class="row">

        <div class="col-sm-7">
            <h2>Formulaire</h2>

            {!! Form::open(['class' => 'form-horizontal']) !!}

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
                {!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('type', ['tvshow' => 'Série', 'movie' => 'Film'], null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('query', 'Recherche', ['class' => 'col-sm-2 control-label']) !!}

                <div class="col-sm-10">
                    {!! Form::text('query', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3 col-sm-offset-9">
                    {!! Form::submit('Rechercher', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'search']) !!}
                </div>
            </div>

            {!! Form::close() !!}

        </div>

        <div class="col-sm-5">
            <h2>Informations</h2>
            <p class="well">
                <b>Fichier :</b> {{ $info['basename'] }}<br>
                <b>Taille :</b> {{ $info['size'] }} Mo<br>
                <b>Mime :</b> {{ $info['mime'] }}<br>
            </p>
        </div>

    </div>


@endsection


@section('js-inline')




@endsection