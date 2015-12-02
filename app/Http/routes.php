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

Route::get('/', function () {
    return view('welcome');
});


/**
 *
 * *****************
 * ADMIN - PHOENIX
 * *****************
 *
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'UserController@home')->name('home');
    Route::get('/logout', function() {Auth::logout(); return redirect()->route('login');})->name('logout');
    Route::controller('user', 'UserController');
    Route::controller('file', 'FileController');

    // Development routes
    Route::group(['middleware' => 'development'], function () {
        Route::get('/dev-layout', 'DevController@layout')->name('dev-layout');
        Route::get('/dev-script', 'DevController@script')->name('dev-script');
    });

});

Route::get('/login', function() {return Auth::check() ? redirect()->route('home') : view('login');})->name('login');
Route::get('/login-with-fb', 'AuthController@facebook')->name('login-with-fb');


Route::get('/no-access', function() {

    if (!Auth::check()) {return redirect()->route('login');}

    // @todo Faire un page plus propre
    return 'Un admin va gerer votre compte';
})->name('no-access');


Route::get('/media/{id}', 'MediaController@show')->name('media-show');
Route::get('/media/dl/{id}', 'MediaController@download')->name('media-dl');
