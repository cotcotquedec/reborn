<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/login', 'DefaultController@auth')->name('login');
Route::any('/login-with-fb', 'DefaultController@facebook')->name('login.facebook');
Route::group(['middleware' => 'auth'], function () {
// Home
    Route::get('/', 'DefaultController@index')->name('home');


    // Media
    Route::get('/search', 'MediaController@search')->name('search');
    Route::get('/files', 'MediaController@files')->name('files');
    Route::get('/tvshows', 'MediaController@tvshows')->name('tvshows');
    Route::get('/movies', 'MediaController@movies')->name('movies');
    Route::any('/stock/movie/{media}', 'MediaController@stockMovie')->name('stock.movie');
    Route::get('/stock/{media}/{tmdb?}', 'MediaController@stock')->name('stock');
    Route::get('/delete/{media}', 'MediaController@delete')->name('media.delete');
    Route::match(['get', 'post'], '/direct', 'MediaController@direct')
        ->middleware('modal', 'form')
        ->name('direct');

    Route::get('/tasks', 'TasksController@index')->name('tasks');
    Route::match(['get', 'post'], '/tasks/downloads', 'TasksController@downloads')
        ->middleware('table')
        ->name('tasks.downloads');
    Route::get('/download/{media}', 'MediaController@download')->name('download');
    Route::match(['get', 'delete'], '/tasks/downloads/delete/{uuid}', 'TasksController@delete')
        ->middleware('modal', 'form')
        ->name('tasks.downloads.delete');


    Route::get('/logout', 'DefaultController@logout')->name('logout');

// Development routes
    Route::group(['middleware' => 'development'], function () {
        Route::any('/dev-layout', 'DevController@layout')->name('dev-layout');
        Route::any('/dev-script', 'DevController@script')->name('dev-script');
    });
});


//require_once frenchfrogs_path('/App/Http/routes.php');


