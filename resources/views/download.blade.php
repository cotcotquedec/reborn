@extends('layout')

@section('content')
    <h3 class="page-title">
        Téléchargements
    </h3>

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ route('home') }}">Acceuil</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Téléchargements</a>
            </li>
        </ul>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Téléchargements direct
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" class="form-horizontal" method="POST" action="{{action('DownloadController@postDirectDownload')}}">
                        <?php echo csrf_field(); ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="direct-link">Lien</label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input name="direct-link" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-info">Télécharger</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Torrent
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{action('DownloadController@postTorrent')}}">
                        <?php echo csrf_field(); ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="direct-link">Fichier</label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="file" name="torrent" class="form-control" accept="application/x-bittorrent">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn btn-info">Uploader</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- END PAGE CONTENT-->
@endsection