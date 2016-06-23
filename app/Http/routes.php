<?php

// Public
Route::any('/login', 'AuthController@login')->name('login');


// Loggué
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'UserController@home')->name('home');
    Route::get('/logout', function() {Auth::logout(); return redirect()->route('login');})->name('logout');

    Route::controller('user', 'UserController');
    Route::controller('schedule', 'ScheduleController');
    Route::controller('reference', 'ReferenceController');
    Route::controller('jobmaker', 'JobmakerController');

    // Development routes
    Route::group(['middleware' => 'development'], function () {
        Route::any('/dev-layout', 'DevController@layout')->name('dev-layout');
        Route::get('/dev-script', 'DevController@script')->name('dev-script');
    });
});


Route::get('/no-access', function() {
    if (!Auth::check()) {return redirect()->route('login');}
    // @todo Faire un page plus propre
    return 'Un admin va gerer votre compte';
})->name('no-access');
