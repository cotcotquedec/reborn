@extends('app')

@section('content')
    <h1 class="page-header">Fichiers</h1>

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>


@endsection


@section('js-inline')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#elfinder').elfinder({
                url : '/elfinder/connector'  // connector URL (REQUIRED)
                // , lang: 'ru'                    // language (OPTIONAL)
            });
        });
    </script>
@endsection
