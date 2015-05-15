@extends('app')

@section('content')
    <div class="page-header">
    <h1>Fichiers</h1>
        <p class="lead">Gestion des fichiers, merci de trier au plus vite, ils seront automatiquement effacés au bout de 5 jours</p>
    </div>


    <table class="table">
        <tr class="row">
            <th class="col-md-9">Nom</th>
            <th class="col-md-3">Options</th>
        </tr>

        @forelse($content as $row)
            <tr class="row">
                <td><i class="{{ $row['icon'] }}"></i>{{ $row['name'] }}</td>
                <td>
                    @foreach($row['options'] as $value => $option)
                        <a href="{{ $option['url'] }}" class="{{ $option['class'] }}"><i class="{{ $option['icon'] }}"></i>{{ $value }}</a>
                    @endforeach
                </td>
            </tr>
        @empty
            <tr class="row">
                <td>Vide</td>
            </tr>
        @endforelse


    </table>


@endsection