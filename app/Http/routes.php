<?php

// Public
Route::get('/login', function() {return Auth::check() ? redirect()->route('home') : view('login');})->name('login');
Route::get('/login-with-google', 'AuthController@google')->name('login-with-google');


// Loggué
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'UserController@home')->name('home');
    Route::get('/logout', function() {Auth::logout(); return redirect()->route('login');})->name('logout');

    Route::controller('user', 'UserController');
    Route::controller('schedule', '\FrenchFrogs\Scheduler\Http\Controllers\ScheduleController');
    Route::controller('tool', 'ToolController');

    // Development routes
    Route::group(['middleware' => 'development'], function () {
        Route::get('/dev-layout', 'DevController@layout')->name('dev-layout');
        Route::get('/dev-script', 'DevController@script')->name('dev-script');
    });
});


Route::get('/no-access', function() {
    if (!Auth::check()) {return redirect()->route('login');}
    // @todo Faire un page plus propre
    return 'Un admin va gerer votre compte';
})->name('no-access');
