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
                Pilipili
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

            <li>
                <button class="btn btn-primary modal-remote" href="/article/add" data-target="#modal-remote" data-method="post" style="margin-top:5px;">Sourcer</button>
                <button class="btn btn-default modal-remote" href="{{ action_url(\App\Http\Controllers\UserController::class, 'postParameter', user('user_id'))}}" title="Paramètres" data-target="#modal-remote" data-method="post" style="margin-top:5px;">
                    <i class="fa fa-cogs"></i>
                </button>
            </li>

            <li class="devider">
                &nbsp;
            </li>
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" width="29" src="{{ route('media-show', uuid('hex', user('media_id'))) }}"/>
                    <span class="username username-hide-on-mobile">{{ user('name') }} </span>
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
            {!! \Models\Business\Analytics::realtime() !!}
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
       2015 &copy; Pilipili.
    </div>
    <div class="footer-tools">
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

    /**
     *
     * Charge les meta pour les source d'article
     *
     * @returns {boolean}
     */
    function populateSourceFromUrl() {
        jQuery.post('/tool/read-meta', {url : $('#source_url').val()}, function(d) {
            $('#add_source').populate(eval(d));
        });

        return false;
    }

    /**
     *
     * Charge le titre dans le message pour le distributor
     *
     * @returns {boolean}
     */
    function populateTitleFromUrl() {
        jQuery.post('/tool/read-meta', {url : $('#link').val()}, function(d) {
            data = eval(d);
            $('#message').val(data.source_title);
        });

        return false;
    }

    /**
     *
     * OUvertur multiplke de page facebook dans de nouveaux onglets
     *
     * @param page
     * @returns {boolean}
     */
    function openFacebookPages(page) {
        $.each(page.split(','),function(i,v) {
            window.open('http://www.facebook.fr/' + v,'_blank');
        });
        return false;
    }

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