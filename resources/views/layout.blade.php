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
    ->title('Pilipili' . (App::environment() != 'production' ? ' | ' . App::environment() : ''))
    ->meta('viewport', 'width=device-width, initial-scale=1.0')
    ->meta('MobileOptimized', '320')
    ->favicon('/favicon.ico')
    !!}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {!! Cache::get('minify.css') !!}

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
            <a href="{{route('home')}}" class="btn btn-lg" style="color:#fff">
                <i class="fa fa-fire"></i>
                &nbsp;&nbsp;Jobmaker
            </a>
        </div>

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
                    <span class="username username-hide-on-mobile">{{ user('name') }} </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('logout') }}"><i class="fa fa-key"></i> Déconnexion</a>
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
            {!! ruler()->renderNavigation() !!}
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
       2016 &copy; Jobmaker.
    </div>
    <div class="footer-inner footer-tools">
        <i>{{ \Carbon\Carbon::now()->format('d/m H:i') }}</i>
    </div>
</div>

{!! \FrenchFrogs\Modal\Modal\Modal::renderRemoteEmptyModal() !!}
{!! Cache::get('minify.js') !!}


@yield('inline')
{!! js('inline') !!}


<script type="text/javascript">

    jQuery( document ).ajaxSend(function(e) {
        jQuery('.btn').disable();
    });

    jQuery( document ).ajaxStop(function() {
        if (jQuery.active == 0) {
            jQuery('.btn').enable();
        }
    });

    // ONLOAD
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
