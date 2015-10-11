@extends('layout')



@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Utilisateurs</h1>

            @include('breadcrumb')


            {!! $table !!}
        </div>
    </div>
    <!-- END PAGE CONTENT-->
@endsection