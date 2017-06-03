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
                    @foreach($medias as $media)

                        @php($info = $media->data)

                        <div class="col-md-6">
                            <!-- Widget: user widget style 1 -->

                            <div class="box box-primary">
                                <div class="box-body"
                                     style="background-size: cover;background-image: url('{{$image->getUrl($info['search']['backdrop_path'], 'w780')}}')">

                                    {{--@php(d($info))--}}
                                    <div style="padding: 5px 15px;background: rgba(255,255,255,.9);">
                                        <div style="min-height: 135px;">
                                            <img src="{{$image->getUrl($info['search']['poster_path'], 'w92')}}"
                                                 style="margin-right: 10px;" class="pull-left">

                                            <div>
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
                                                <p>
                                                    <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{$media->created_at->formatLocalized('%A %d %B %Y')}}
                                                </p>
                                                <p class="text-muted">
                                                    {{$info['episode']['data']['overview']}}
                                                </p>

                                                <p>
                                                    <i class="fa fa-file margin-r-5"></i>
                                                    <a href="{{route('download', [uuid($media->getKey())->hex])}}">{{basename($media->name)}}</a>
                                                </p>
                                            </div>


                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    @endforeach
                </div>

            </section>
        </div>
    </div>
@endsection