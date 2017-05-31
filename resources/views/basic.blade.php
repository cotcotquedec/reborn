@extends('layout')

@section('content')
    <div class="content-wrapper loading-clock">
        <div style="display:none;">
            <section class="content-header">
                <h1>
                    {{ $title }}
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                {!! $content !!}
            </section>
        </div>
    </div>
@endsection