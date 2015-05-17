@extends('app')

@section('content')
    <div class="page-header">
        <h1>Trier</h1>

        <p class="alert alert-warning ">Avec ce formulaire, vous ranger les fichiers pour qu'ils soient conservés et accessibles via les univers "Séries" et "Films"</p>
    </div>


    <div class="row">

        <div class="col-sm-6">
            <h2>Formulaire</h2>

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
                {!! Form::label('type', 'Type', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('type', ['tvshow' => 'Série', 'movie' => 'Film'], Input::get('type') , ['class' => 'form-control']) !!}
                </div>
            </div>

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

        <div class="col-sm-6">
            <h2>Informations</h2>
            <p class="well">
                <b>Fichier :</b> {{ $info['basename'] }}<br>
                <b>Taille :</b> {{ $info['size'] }} Mo<br>
                <b>Mime :</b> {{ $info['mime'] }}<br>
            </p>
        </div>

    </div>


    <div class="row">

            <h2>Resultats</h2>

            @forelse($result as $row)

                <div class="col-sm-6">
                    <div  class="well">

                        <div class="clearfix">
                            <a href="#" class="btn btn-primary pull-right" title="Choisir un épisode">
                                Choisir
                            </a>

                            <span class="lead">
                                {{ $row['name'] }}
                            </span>
                            <i>({{ $row['year'] }})</i>
                        </div>

                        <p >{{ $row['overview'] }}</p>

                        <img src="{{ $row['banner'] }}" width="100%">
                    </div>
                </div>

            @empty
                <div class="col-sm-12">
                    <p class="alert alert-warning">Nous n'avons pas trouvé de résultat pour votre recherche</p>
                </div>
            @endforelse

        </div>

    </div>


@endsection


@section('js-inline')




@endsection