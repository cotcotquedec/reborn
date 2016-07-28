@extends('layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        {!! $content !!}
    </section>
@endsection