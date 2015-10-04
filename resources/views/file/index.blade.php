@extends('layout')

@section('content')

    <h3 class="page-title">
        Fichiers
    </h3>

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ route('home') }}">Acceuil</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Fichiers</a>
            </li>
        </ul>
    </div>

<div>
    <table class="table table-striped table-hover">
        <tr class="row">
            <th class="col-md-1">Taille</th>
            <th class="col-md-8">Nom</th>
            <th class="col-md-3 text-right">Options</th>
        </tr>

        @forelse($content as $row)
        <tr class="row">

            @if($row['type'] == 'directory')

            <td></td>
            <td><b>{{ $row['name'] }}</b></td>
            <td class="text-right">
                @foreach($row['options'] as $option)
                <a href="{{ $option['url'] }}" class="{{ $option['class'] }}" data-toggle="tooltip" title="{{ $option['title'] }}">
                    <i class="{{ $option['icon'] }}"></i>
                </a>
                @endforeach
            </td>

            @else

                <td>{{ $row['size'] }}</td>
            <td>{{ $row['name'] }}</td>
            <td class="text-right">
                @foreach($row['options'] as $option)
                <a href="{{ $option['url'] }}" class="{{ $option['class'] }}" data-toggle="tooltip" title="{{ $option['title'] }}">
                    <i class="{{ $option['icon'] }}"></i>
                </a>
                @endforeach
            </td>
            @endif
        </tr>
        @empty
        <tr class="row">
            <td>Vide</td>
        </tr>
        @endforelse
    </table>
</div>


@endsection


@section('js-inline')
<script>
    function fileDelete(name, url)
    {
        if (confirm('Etes vous sûr de vouloir supprimer "' + name + '" ?'))
        {
            window.location.href = url;
        }

        return false;
    }
</script>
@endsection