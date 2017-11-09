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
                    Films
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    @foreach($medias as $media)


                        @php($info = $media->data)

                        <div class="col-md-6 col-lg-4" id="{{uuid($media->getKey())->hex}}">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-success box-movie">

                                <div class="box-body"
                                     style="background-size: cover;background-image: url('{{$image->getUrl($info['movie']['backdrop_path'], 'w780')}}')">

                                    <div>
                                        <div>

                                            <div class="row">
                                                <div class="box-summary col-sm-12">
                                                    <img src="{{$image->getUrl($info['movie']['poster_path'], 'w154')}}"
                                                         class="pull-left">

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

                                                    <h3 class="box-title">{{$info['movie']['title']}}</h3>
                                                    @if(!empty($info['movie']['imdb_id']))
                                                        <span class="imdbRatingPlugin"
                                                              data-title="{{$info['movie']['imdb_id']}}"
                                                              data-style="p1">
                                                        <a href="http://www.imdb.com/title/{{$info['movie']['imdb_id']}}/?ref_=plg_rt_1"
                                                           target="_blank">
                                                            <img src="http://g-ecx.images-amazon.com/images/G/01/imdb/plugins/rating/images/imdb_46x22.png"/>
                                                        </a>
                                                        </span>
                                                    @endif
                                                    <p>
                                                        <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{$media->created_at->formatLocalized('%A %d %B %Y')}}
                                                    </p>

                                                    <p>{{$info['movie']['release_date']}}</p>
                                                    <p class="">
                                                        {{$info['movie']['overview']}}
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