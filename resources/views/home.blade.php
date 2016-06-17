@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenu sur pilipili</h1>

            @include('breadcrumb')

            <p class="well">Tu trouves que c'est vide? c'est normal, c'est vide!</p>

            <canvas id="chart-active-users" width="1200" height="400"></canvas>
        </div>
    </div>
@endsection('content')

@section('inline')
    <script>

    var data = {
        labels: {!! json_encode($realtime['time']) !!},
        datasets: [
            {
                label: "Histoires du net",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: {!! json_encode($realtime['hdn_user']) !!}
            },
            {
                label: "Girls & Roses",
                fillColor: "rgba(205,151,187,0.2)",
                strokeColor: "rgba(205,151,187,1)",
                pointColor: "rgba(205,151,187,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(205,151,187,1)",
                data: {!! json_encode($realtime['gnr_user']) !!}
            }
        ]
    };


    var options = {
        scaleBeginAtZero : true,
    };

    var ctx = document.getElementById("chart-active-users").getContext("2d");
    var myLineChart = new Chart(ctx).Line(data, options);
    </script>
@endsection