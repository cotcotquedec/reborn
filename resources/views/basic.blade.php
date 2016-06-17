@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $title }}</h1>

            @include('breadcrumb')

            {!! $content !!}
        </div>
    </div>
@endsection