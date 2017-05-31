<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><i class="fa fa-home"></i></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ configurator()->get('app.name')  }}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{user('media_uuid') ? route('media-show', uuid(user('media_uuid'))->hex) : '/frenchfrogs/dist/img/stormtrooper.jpg' }}"
                             class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ user('name') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{user('media_uuid') ? route('media-show', uuid(user('media_uuid'))->hex) : '/frenchfrogs/dist/img/stormtrooper.jpg' }}"
                                 class="img-circle" alt="User Image">
                            <p>
                                {{ user('name') }}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('login.facebook') }}" class="btn btn-primary btn-flat"><i
                                            class="fa fa-facebook"></i> facebook</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-danger btn-flat">Deconnexion</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

            <div class="pull-left image">
                <img src="{{user('media_uuid') ? route('media-show', uuid(user('media_uuid'))->hex) : '/frenchfrogs/dist/img/stormtrooper.jpg' }}"
                     class="img-circle" alt="User Image">
            </div>

            <div class="pull-left info">
                <p>{{ user('name') }}</p>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        {!! ruler()->renderNavigation() !!}
    </section>
    <!-- /.sidebar -->
</aside>