@extends('layout')

@section('content')
    <div class="content-wrapper loading-clock">
        <div style="display:none;">
            <section class="content-header">
                <h1>
                    Téléchargements
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="table-remote" data-url="{{ route('tasks.downloads')}}"></div>
            </section>
        </div>
    </div>
@endsection