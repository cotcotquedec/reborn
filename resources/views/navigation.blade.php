@php
    $current = Route::currentRouteName();
@endphp


<form action="{{route('search')}}" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" value="{{$current == 'search' ? request()->get('q', '') : '' }}"
               class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="button" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>


<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MEDIAS</li>
    <!-- sidebar menu: : style can be found in sidebar.less -->


    <li class="{{$current === 'movies' ? 'active' : ''}}">
        <a href="{{route('movies')}}">
            <i class="fa fa-film"></i> <span>Films</span>
        </a>
    </li>


    <li class="{{$current === 'tvshows' ? 'active' : ''}}">
        <a href="{{route('tvshows')}}">
            <i class="fa fa-tv"></i> <span>Series</span>
        </a>
    </li>


    <li class="header">TOOLS</li>

    <li class="{{$current === 'files' ? 'active' : ''}}">
        <a href="{{route('files')}}">
            <i class="fa fa-file"></i> <span>Fichiers</span>
        </a>
    </li>

    <li class="{{$current === 'tasks' ? 'active' : ''}}">
        <a href="{{route('tasks')}}">
            <i class="fa fa-download"></i> <span>Téléchargements</span>
        </a>
    </li>


    {{--<li class="treeview">--}}
    {{--<a href="#">--}}
    {{--<i class="fa fa-bullhorn"></i> <span>Marketing</span>--}}
    {{--<span class="pull-right-container">--}}
    {{--<i class="fa fa-angle-left pull-right"></i>--}}
    {{--</span>--}}
    {{--</a>--}}


    {{--<ul class="treeview-menu">--}}

    {{--<li class="{{$current == 'backoffice.marketing.seo' ? 'active' : ''}}">--}}
    {{--<a href="{{route('backoffice.marketing.seo')}}"><i class="fa fa-circle-o"></i>SEO</a>--}}
    {{--</li>--}}


    {{--</ul>--}}
    {{--</li>--}}

</ul>