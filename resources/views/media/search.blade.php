@extends('layout')
@php
    /** @var \App\Models\Db\Medias $media */

//dd($medias);
@endphp

@inject('image', 'Tmdb\Helper\ImageHelper')

@section('content')
    <div class="content-wrapper loading-clock">
        <div style="display:none;">

            @if(!empty($medias))
                <section class="content-header">
                    <h1>
                        Recherche : <i>{{$medias['query']}}</i>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        @foreach($medias['hits'] as $media)
                            @php
                                $info = data_get($media, 'data');
                                $uuid = uuid(data_get($media, 'uuid'))->hex;
                            @endphp

                            @if ($media['type_rid'] == \Ref::MEDIA_TYPE_MOVIE)

                                <div class="col-md-6 col-lg-4" id="{{$uuid}}">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-success box-movie">
                                        <div class="box-body"
                                             style="background-size: cover;background-image: url('{{$image->getUrl($info['backdrop_path'], 'w780')}}')">
                                            <div>
                                                <div>

                                                    <div class="row">
                                                        <div class="box-summary col-sm-12">
                                                            <img src="{{$image->getUrl($info['poster_path'], 'w154')}}"
                                                                 class="pull-left">

                                                            <a href="{{route('media.delete', [$uuid])}}"
                                                               class="btn btn-danger btn-sm pull-right modal-remote"
                                                               data-method="GET"
                                                               data-target="#modal-remote">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            <a href="{{route('download', [$uuid])}}"
                                                               class="btn btn-primary btn-sm pull-right">
                                                                <i class="fa fa-download"></i>
                                                            </a>

                                                            <h3 class="box-title">{{$info['title']}}</h3>
                                                            @if(!empty($info['imdb_id']))
                                                                <span class="imdbRatingPlugin"
                                                                      data-title="{{$info['imdb_id']}}"
                                                                      data-style="p1">
                                                        <a href="http://www.imdb.com/title/{{$info['imdb_id']}}/?ref_=plg_rt_1"
                                                           target="_blank">
                                                            <img src="http://g-ecx.images-amazon.com/images/G/01/imdb/plugins/rating/images/imdb_46x22.png"/>
                                                        </a>
                                                        </span>
                                                            @endif

                                                            <p>
                                                                <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{ \Carbon\Carbon::createFromTimeString($media['created_at'])->formatLocalized('%A %d %B %Y')}}
                                                            </p>

                                                            <p>{{$info['release_date']}}</p>
                                                            <p class="">
                                                                {{$info['overview']}}
                                                            </p>
                                                        </div>

                                                        <div class="clearfix"></div>

                                                        <div class="box-file col-sm-12">

                                                            <hr>
                                                            <p class="well">
                                                                <i class="fa fa-file margin-r-5"></i>
                                                                <a href="{{route('download', [$uuid])}}">{{basename($media['name'])}}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($media['type_rid'] == \Ref::MEDIA_TYPE_TVSHOW)

                                <div class="col-md-6 col-lg-4" id="{{$uuid}}">

                                    <div class="box box-primary box-movie">
                                        <div class="box-body"
                                             style="background-size: cover;background-image: url('{{$image->getUrl($info['tvshow']['backdrop_path'], 'w780')}}')">
                                            <div>
                                                <div>
                                                    <div class="row">
                                                        <div class="box-summary col-sm-12">

                                                            <img src="{{$image->getUrl($info['tvshow']['poster_path'], 'w154')}}"
                                                                 style="margin-right: 10px;" class="pull-left">

                                                            <a href="{{route('media.delete', [$uuid])}}"
                                                               class="btn btn-danger btn-sm pull-right modal-remote"
                                                               data-method="GET"
                                                               data-target="#modal-remote">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            <a href="{{route('download', [$uuid])}}"
                                                               class="btn btn-primary btn-sm pull-right">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                            <h3 class="box-title">

                                                                {{
                                                                sprintf('%s S%02sE%02s',
                                                                $info['tvshow']['name'],
                                                                $info['episode']['season_number'], $info['episode']['episode_number'])
                                                                }}
                                                            </h3>


                                                            <h4>{{$info['episode']['name']}}</h4>
                                                            @if(!empty($info['episode']['imdb_id']))
                                                                <span class="imdbRatingPlugin"
                                                                      data-title="{{$info['episode']['imdb_id']}}"
                                                                      data-style="p1">
                                                        <a href="http://www.imdb.com/title/{{$info['episode']['imdb_id']}}/?ref_=plg_rt_1"
                                                           target="_blank">
                                                            <img src="http://g-ecx.images-amazon.com/images/G/01/imdb/plugins/rating/images/imdb_46x22.png"/>
                                                        </a>
                                                        </span>
                                                            @endif
                                                            <p>
                                                                <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{ \Carbon\Carbon::createFromTimeString($media['created_at'])->formatLocalized('%A %d %B %Y')}}
                                                            </p>
                                                            <p class="text-muted">
                                                                {{$info['episode']['overview']}}
                                                            </p>


                                                        </div>


                                                        <div class="clearfix"></div>
                                                        <div class="box-file col-sm-12">

                                                            <hr>
                                                            <p class="well">
                                                                <i class="fa fa-file margin-r-5"></i>
                                                                <a href="{{route('download', [$uuid])}}">{{basename($media['name'])}}</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection