@extends('layout')
@php
    /** @var \App\Models\Db\Medias $media */

@endphp

@inject('image', 'Tmdb\Helper\ImageHelper')

@section('content')
    <div class="content-wrapper loading-clock">
        <div style="display:none;">
            <section class="content-header">
                <h1>
                    Séries
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xs-12 col-sm-offset-8 col-sm-4">
                        <form action="{{url()->current()}}" method="get" style="margin: 15px 0px;">
                            <div class="input-group">
                                <input type="text" name="q" value="{{$q}}" class="form-control input-lg" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button type="submit" id="search-btn" class="btn btn-flat btn-lg">
                                        <i class="fa fa-search"></i>
                                    </button>
                                  </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    @foreach($medias as $media)

                        @php($info = $media->data)

                        <div class="col-md-6 col-lg-4" id="{{uuid($media->getKey())->hex}}">
                            <!-- Widget: user widget style 1 -->

                            <div class="box box-primary box-movie">
                                <div class="box-body"
                                     style="background-size: cover;background-image: url('{{$image->getUrl($info['search']['backdrop_path'], 'w780')}}')">
                                    <div>
                                        <div>
                                            <div class="row">
                                                <div class="box-summary col-sm-12">

                                                    <img src="{{$image->getUrl($info['search']['poster_path'], 'w154')}}"
                                                         style="margin-right: 10px;" class="pull-left">

                                                    <a href="{{route('media.delete', [uuid($media->getKey())->hex])}}"
                                                       class="btn btn-danger btn-sm pull-right modal-remote"
                                                       data-method="GET"
                                                       data-target="#modal-remote">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <a href="{{route('download', [uuid($media->getKey())->hex])}}"
                                                       class="btn btn-primary btn-sm pull-right">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <h3 class="box-title">

                                                        {{
                                                        sprintf('%s S%02sE%02s',
                                                        $info['tvshow']['data']['name'],
                                                        $info['episode']['data']['season_number'], $info['episode']['data']['episode_number'])
                                                        }}
                                                    </h3>


                                                    <h4>{{$info['episode']['data']['name']}}</h4>
                                                    @if(!empty($info['episode']['ids']['imdb_id']))
                                                        <span class="imdbRatingPlugin"
                                                              data-title="{{$info['episode']['ids']['imdb_id']}}"
                                                              data-style="p1">
                                                        <a href="http://www.imdb.com/title/{{$info['episode']['ids']['imdb_id']}}/?ref_=plg_rt_1"
                                                           target="_blank">
                                                            <img src="http://g-ecx.images-amazon.com/images/G/01/imdb/plugins/rating/images/imdb_46x22.png"/>
                                                        </a>
                                                        </span>
                                                    @endif
                                                    <p>
                                                        <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{$media->created_at->formatLocalized('%A %d %B %Y')}}
                                                    </p>
                                                    <p class="text-muted">
                                                        {{$info['episode']['data']['overview']}}
                                                    </p>


                                                </div>


                                                <div class="clearfix"></div>
                                                <div class="box-file col-sm-12">

                                                    <hr>
                                                    <p class="well">
                                                        <i class="fa fa-file margin-r-5"></i>
                                                        <a href="{{route('download', [uuid($media->getKey())->hex])}}">{{basename($media->name)}}</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        {{$medias->links()}}
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection