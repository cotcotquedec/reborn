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
    Route::any('/', 'DefaultController@index')->name('home');
    Route::get('/logout', 'DefaultController@logout')->name('logout');
    \FrenchFrogs\App\Models\Route::load([
//    'user' => Controllers\UserController::class,
//    'schedule' => Controllers\ScheduleController::class,
//    'reference' => Controllers\ReferenceController::class,
    ], is_debug()
    )->register();
// Development routes
    Route::group(['middleware' => 'development'], function () {
        Route::any('/dev-layout', 'DevController@layout')->name('dev-layout');
        Route::any('/dev-script', 'DevController@script')->name('dev-script');
    });
});



