<!DOCTYPE html>
<!-- 
Template Name: Conquer - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 2.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="fr" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="fr" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fr" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Reborn | Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ URL::asset('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ URL::asset('assets/css/style-conquer.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/style-responsive.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/pages/tasks.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/themes/default.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{ URL::asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route('home')}}" class="btn btn-lg">
                Reborn
            </a>
        </div>
        <form class="search-form search-form-header" role="form" action="index.html">
            <div class="input-icon right">
                <i class="icon-magnifier"></i>
                <input type="text" class="form-control input-sm" name="query" placeholder="Search...">
            </div>
        </form>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="{{ URL::asset('assets/img/menu-toggler.png') }}" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">

            <li class="devider">
                &nbsp;
            </li>
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" width="29" src="{{route('media-show',Auth::getUser()->first()->media_id)}}"/>
                    <span class="username username-hide-on-mobile">{{ Auth::getUser()->name }} </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('logout') }}"><i class="fa fa-key"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: for circle icon style menu apply page-sidebar-menu-circle-icons class right after sidebar-toggler-wrapper -->
            <ul class="page-sidebar-menu">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <div class="clearfix">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>
                <li class="sidebar-search-wrapper">
                    <form class="search-form" role="form" action="index.html" method="get">
                        <div class="input-icon right">
                            <i class="icon-magnifier"></i>
                            <input type="text" class="form-control" name="query" placeholder="Search...">
                        </div>
                    </form>
                </li>
                <li class="start">
                    <a href="{{route('home')}}">
                        <i class="icon-home"></i>
                        <span class="title">Accueil</span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ URL::action('FileController@getIndex')}}">
                        <i class="icon-docs"></i>
                        <span class="title">Fichiers</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ URL::action('DownloadController@getIndex')}}">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Téléchargements</span>
                    </a>
                </li>
                <li class="last ">
                    <a href="{{ route('user.index') }}">
                        <i class="icon-user"></i>
                        <span class="title">Utilisateurs</span>
                    </a>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            @yield('content')
        </div>
    </div>


    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2015 &copy; Reborn.
    </div>
    <div class="footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
    </div>
</div>

{!! \FrenchFrogs\Polliwog\Modal\Modal\Bootstrap::renderRemoteEmptyModal() !!}

        <!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::asset('assets/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset('assets/scripts/app.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/scripts/datatable.js') }}"></script>
<script src="{{ URL::asset('assets/scripts/table-ajax.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->


@yield('js-inline')
<script>
    jQuery(document).ready(function() {

        App.init(); // initlayout and core plugins
        TableAjax.init();
        {!! js('inline') !!}

        // decoration datatable
        $('table.table > thead > tr:last-child').children().css('border-bottom', '1px solid #ddd');

    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>