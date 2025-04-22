<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::group(['namespace' => 'Authorization'], function () {

        Route::get('/email/verify/{id}/{hash}', 'RegisterController@verify_mail')->name('verification.verify');
        Route::get('/email/verification-notification', 'RegisterController@wait_verify')->name('verification.resend');
        Route::post('/email/verification-notification', 'RegisterController@resend_verification')->name('verification.resend.perform');

        Route::group(['middleware' => ['guest']], function () {
            /**
             * Register Routes
             */
            Route::get('/register', 'RegisterController@show')->name('register.show');
            Route::post('/register', 'RegisterController@register')->name('register.perform');

            /**
             * Login Routes
             */
            Route::get('/login', 'LoginController@show')->name('login');
            Route::post('/login', 'LoginController@login')->name('login.perform');

            /**
             * Home Routes
             */
            // Route::get('/', function () {
            //     return redirect()->route('login.show');
            // });
        });
    });


    Route::get('/', 'HomeController@guest_show')->name('home.show');

    
    #========================================
    #============= panel pages ==============
    #========================================

    Route::group(['middleware' => ['auth']], function () {
        // Başarılı Giriş

        Route::group(['namespace' => 'Authorization'], function () {
            Route::get('/logout', 'LogoutController@perform')->name('logout');
        });


        Route::group(['middleware' => ['verified']], function () {
            // Onaylı hesaplar

            Route::get('/', 'HomeController@show')->name('home.show');
        });
    });

});
