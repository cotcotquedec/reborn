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
                    Fichiers
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">

                    @if($medias->isEmpty())
                        <section class="content">

                            <div class="error-page">
                                <h2 class="headline text-red">Cool!</h2>

                                <div class="error-content">
                                    <h3>Aucun Fichier à trier.</h3>

                                    <p>
                                        Je vais mettre ici les informations pour télécharger des fichiers, soyez patient
                                    </p>
                                </div>
                            </div>
                            <!-- /.error-page -->

                        </section>
                    @endif

                    @foreach($medias as $media)

                        @if($media->isTvShow())
                            <div class="col-md-6">
                                <!-- Widget: user widget style 1 -->
                                <div class="box box-primary">

                                    <div class="box-header with-border">
                                        <h3 class="box-title">Série</h3>
                                    </div>

                                    <div class="box-body">
                                        <p><strong>{{basename($media->name)}}</strong></p>
                                        <p>
                                            <strong><i class="fa fa-clock-o margin-r-5"></i></strong> {{$media->created_at->formatLocalized('%A %d %B %Y')}}
                                        </p>

                                        {{--<div>--}}
                                        {{--<a class="btn btn-primary"><i class="fa fa-download"></i></a>--}}
                                        {{--<a class="btn btn-danger"><i class="fa fa-trash"></i></a>--}}
                                        {{--</div>--}}

                                        <hr>

                                        @foreach($media->search_info as $id => $info)
                                            {{--@php(d($info))--}}
                                            <div style="background-size: cover;background-image: url('{{$image->getUrl($info['search']['backdrop_path'], 'w780')}}')">
                                                <div style="padding: 15px;background: rgba(255,255,255,.8);">

                                                    <p>

                                                        <a href="{{route('stock', [uuid($media->getKey())->hex, $id])}}"
                                                           class="btn btn-primary pull-right callback-remote">
                                                            <i class="fa fa-sign-in"></i>
                                                        </a>
                                                        <strong><i class="fa fa-film margin-r-5"></i>
                                                            {{$info['tvshow']['data']['name']}}
                                                            S{{$info['episode']['data']['season_number']}}
                                                            E{{$info['episode']['data']['episode_number']}}</strong>
                                                    </p>


                                                    <div style="min-height: 135px;">
                                                        <img src="{{$image->getUrl($info['search']['poster_path'], 'w92')}}"
                                                             style="margin-right: 10px;" class="pull-left">

                                                        <div>
                                                            <h3>{{$info['tvshow']['data']['name']}}</h3>
                                                            <p>{{$info['episode']['data']['air_date']}}  {{$info['episode']['data']['name']}}</p>
                                                            <p class="text-muted">
                                                                {{$info['episode']['data']['overview']}}
                                                            </p>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                        @endforeach
                                    </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>
                        @endif
                    @endforeach
                </div>

            </section>
        </div>
    </div>
@endsection