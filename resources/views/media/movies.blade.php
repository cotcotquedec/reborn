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

                        <div class="col-md-12">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-success">

                                <div class="box-body"
                                     style="background-size: cover;background-image: url('{{$image->getUrl($info['movie']['backdrop_path'], 'w780')}}')">

                                    <div style="padding: 5px 15px;background: rgba(255,255,255,.9);">
                                        <div style="min-height: 135px;">
                                            <img src="{{$image->getUrl($info['movie']['poster_path'], 'w92')}}"
                                                 style="margin-right: 10px;" class="pull-left">

                                            <div>
                                                <a href="{{route('download', [uuid($media->getKey())->hex])}}"
                                                   class="btn btn-primary btn-sm pull-right">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <h3 class="box-title">{{$info['movie']['title']}}</h3>
                                                <p>
                                                    <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{$media->created_at->formatLocalized('%A %d %B %Y')}}
                                                </p>
                                                <p>{{$info['movie']['release_date']}}</p>
                                                <p class="text-muted">
                                                    {{$info['movie']['overview']}}
                                                </p>
                                            </div>

                                            <div class="clearfix"></div>
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
                    @endforeach
                </div>

            </section>
        </div>
    </div>
@endsection