<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
    return redirect('/home');
});



Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('fichier/{dir?}', ['as' => 'file-list', 'uses' => 'FileController@index']);
Route::get('fichier/supprimer/{file}', ['as' => 'file-del', 'uses' => 'FileController@delete']);
Route::get('fichier/supprimer-repertoire/{dir}', ['as' => 'file-deldir', 'uses' => 'FileController@deleteDirectory']);
Route::any('fichier/trier/{file}', ['as' => 'file-classify', 'before' => 'csrf', 'uses' => 'FileController@classify']);
//Route::post('fichier/trier/{file}/tvshow', ['as' => 'file-classify-tvshow', 'uses' => 'FileController@classifyTvShow']);

Route::post('tvshow/loadepisode', ['as' => 'tvshow-loadepisode', 'uses' => 'TvshowController@loadepisode']);
Route::post('tvshow/loadtvshow', ['as' => 'tvshow-loadtvshow', 'uses' => 'TvshowController@loadtvshow']);
Route::get('tvshow/import', ['as' => 'tvshow-import', 'uses' => 'TvshowController@import']);

Route::get('fichier/telecharger/{file}', ['as' => 'file-download', function($file) {

    $file = env('XSENDFILE_ROOT') . DIRECTORY_SEPARATOR . base64_decode($file);
    $basename = substr($file, strrpos($file, '/') + 1 );

    header("X-Sendfile: $file");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$basename\"");
    return;
}]);


Route::controllers(['auth' => 'Auth\AuthController']);
