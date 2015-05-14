@extends('app')

@section('content')
    <div class="page-header">
    <h1>Fichiers</h1>
        <p class="lead">Gestion des fichiers, merci de trier au plus vite, ils seront automatiquement effacés au bout de 5 jours</p>
    </div>


    <table class="table">
        <tr>
            <th>Nom</th>
        </tr>


        @forelse($files as $file)
            <tr>
                <td>{{ $file }}</td>

            </tr>
        @empty
            <tr>
                <td>Vide</td>
            </tr>
        @endforelse


    </table>


@endsection