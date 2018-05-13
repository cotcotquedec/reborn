<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
{!!
\h()
->charset('utf-8')
->title( config('app.name') . (app()->environment() != 'production' ? ' | ' . app()->environment() : ''))
->meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no')
!!}

{!! Cache::get('web.css') !!}

<!-- Bugsnag -->
    <script src="//d2wy8f7a9ursnm.cloudfront.net/bugsnag-3.min.js"
            data-apikey="f71290ca8fb2102108b2c1922dfcaa18"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-{{env('ADMINLTE_SKIN', 'black')}} fixed sidebar-mini">
<!-- Site wrapper -->
    @yield('content')
<!-- ./wrapper -->

{!! \FrenchFrogs\Modal\Modal\Modal::renderRemoteEmptyModal() !!}
{!! Cache::get('web.js') !!}


@yield('inline')
{!! js('inline') !!}


<script type="text/javascript">

    // Gestion des bouton
    jQuery(document).ajaxSend(function (e) {
        jQuery('.btn').disable();
    });

    jQuery(document).ajaxStop(function () {
        if (jQuery.active == 0) {
            jQuery('.btn').enable();
        }
    });

    // ONLOAD
    jQuery(document).ready(function () {
        {!! js('onload') !!}
        $('body').initialize(function (e) {
            $('.content-wrapper > div').fadeIn({
                start: function () {
                    $('.content-wrapper').removeClass('loading-clock');
                }
            });
        });
    });
    //-->
</script>
</body>
</html>