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

    {!!
    h()
    ->charset('utf-8')
    ->title(isset($title) ? $title : 'Reborn')
    ->meta('viewport', 'width=device-width, initial-scale=1.0')
    ->meta('MobileOptimized', '320')
    ->favicon('/favicon.ico')
    !!}

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {!!
        css()
        ->enableMinify()
        ->setTargetPath('build')
        ->file('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')
        ->file('/assets/plugins/simple-line-icons/simple-line-icons.min.css')
        ->file('/assets/plugins/bootstrap/css/bootstrap.min.css')
        ->file('/assets/plugins/uniform/css/uniform.default.css')
        ->file('/assets/plugins/select2/select2.css')
        ->file('/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')
        ->file('/assets/plugins/bootstrap-toastr/toastr.min.css')
        ->file('/assets/plugins/bootstrap-datepicker/css/datepicker.css')
        ->file('/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')
        ->file('/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css')
        ->file('/assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css')
        ->file('/assets/plugins/font-awesome/css/font-awesome.min.css')
        ->file('/assets/css/style-conquer.css')
        ->file('/assets/css/style.css')
        ->file('/assets/css/style-responsive.css')
        ->file('/assets/css/plugins.css')
        ->file('/assets/css/pages/tasks.css')
        ->file('/assets/css/themes/default.css')
        ->file('/assets/css/custom.css')
    !!}

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
            <a href="{{route('home')}}" class="btn btn-lg" style="color:#fff;font-weight: 400">
                <i class="fa fa-film"></i>
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
                    <img alt="" width="29" src="{{route('media-show',Uuid::import(Auth::getUser()->media_id))}}"/>
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
                    <a href="{{ action_url('FileController')}}">
                        <i class="icon-docs"></i>
                        <span class="title">Fichiers</span>
                    </a>
                </li>
                <li class="last ">
                    <a href="{{ action_url('UserController') }}">
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

{!! \FrenchFrogs\Modal\Modal\Modal::renderRemoteEmptyModal() !!}

        <!-- END FOOTER -->

<!-- END FOOTER -->
{!!
    js('mini_js')
        ->enableMinify()
        ->setTargetPath('build')
        ->file('/assets/plugins/jquery-1.11.0.min.js')
        ->file('/assets/plugins/jquery-migrate-1.2.1.min.js')
        ->file('/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')
        ->file('/assets/plugins/bootstrap/js/bootstrap.min.js')
        ->file('/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')
        ->file('/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')
        ->file('/assets/plugins/jquery.blockui.min.js')
        ->file('/assets/plugins/uniform/jquery.uniform.min.js')
        ->file('assets/plugins/select2/select2.min.js')
        ->file('assets/plugins/datatables/media/js/jquery.dataTables.min.js')
        ->file('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')
        ->file('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')
        ->file('assets/plugins/bootstrap-toastr/toastr.min.js')
        ->file('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')
        ->file('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')
        ->file('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js')
        ->file('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js')
        ->file(elixir('js/main.js'))
        ->file('/assets/scripts/app.js')
!!}


@yield('inline')
{!! js('inline') !!}

<script type="text/javascript">
    <!--
    jQuery(document).ready(function() {
        App.init(); // initlayout and core plugins
        {!! js('onload') !!}
        $('body').initialize();
    });
    //-->
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>