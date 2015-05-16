@extends('app')

@section('content')
    <div class="page-header">
    <h1>Fichiers</h1>
        <p class="alert alert-warning ">Les fichiers seront automatiquement effacés au bout de 5 jours, merci de trier au plus vite.</p>
    </div>


    <div>
        <table class="table table-striped">
            <tr class="row">
                <th class="col-md-9">Nom</th>
                <th class="col-md-3 text-right">Options</th>
            </tr>

            @forelse($content as $row)
                <tr class="row">

                    @if($row['type'] == 'directory')

                        <td><b>{{ $row['name'] }}</b></td>
                        <td class="text-right">
                            @foreach($row['options'] as $option)
                                <a href="{{ $option['url'] }}" class="{{ $option['class'] }}" data-toggle="tooltip" title="{{ $option['title'] }}">
                                    <i class="{{ $option['icon'] }}"></i>
                                </a>
                            @endforeach
                        </td>

                    @else

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