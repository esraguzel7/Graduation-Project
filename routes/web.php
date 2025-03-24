<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::group(['namespace' => 'Authorization'], function () {

        Route::get('/email/verify/{id}/{hash}', 'Register@verify_mail')->name('authorization.verification.verify');
        Route::get('/email/verification-notification', 'Register@wait_verify')->name('authorization.verification.resend');
        Route::post('/email/verification-notification', 'Register@resend_verification')->name('authorization.verification.resend.perform');

        Route::group(['middleware' => ['guest']], function () {
            /**
             * Register Routes
             */
            Route::get('/register', 'Register@show')->name('authorization.register.show');
            Route::post('/register', 'Register@register')->name('authorization.register.perform');

            /**
             * Login Routes
             */
            Route::get('/login', 'Login@show')->name('authorization.login.show');
            // Route::post('/login', 'Login@login')->name('authorization.login.perform');

        });


        /**
         * Home Routes
         */
        Route::get('/', function () {
            return redirect()->route('authorization.login.show');
        });
    });

    Route::group(['middleware' => ['auth']], function () {
        // Başarılı Giriş



        Route::group(['middleware' => ['verified']], function () {
            // Onaylı hesaplar

            Route::get('/', 'Home@show')->name('home.show');

        });
    });

});
