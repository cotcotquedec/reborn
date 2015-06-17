<div class="container-fluid" style="width:600px">
    <div class="page-header">
        <h3>Importer une nouvelle série</h3>
    </div>

    <div class="row" >

        {!! Form::open(['class' => 'form-horizontal', 'method' => 'GET' ]) !!}


        <div class="form-group">
            {!! Form::label('tvshow-query', 'Recherche', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::text('tvshow-query', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group text-right">
            <div class="col-sm-4 col-sm-offset-8">
                {!! Form::button('Rechercher', ['class' => 'btn btn-lg btn-primary btn-block', 'id' => 'tvshow-search']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('tvshow-select', 'Serie', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
                {!! Form::select('tvshow-select', [] , null, ['class' => 'form-control', 'placeholder' => 'Choisir la série']) !!}
            </div>
        </div>


        <div class="form-group text-right">
            <div class="col-sm-4 col-sm-offset-8">
                {!! Form::submit('Enregistrer', ['class' => 'btn btn-lg btn-primary btn-block disabled', 'disabled' => 'disabled', 'name' => 'tvshow-import', 'id' => 'tvshow-import']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>


<script>

    $(function() {
       $('#tvshow-search').click(function() {
           $('#tvshow-select').loadSelect(
                   '{{ route('tvshow-loadtvshow') }}',
                   {query : $('#tvshow-query').val()},
                   function() {
                       $('#tvshow-import').removeAttr('disabled').removeClass('disabled');
           });
       })
    });

</script>