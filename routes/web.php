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
             * Forgot Password Routes
             */
            Route::get('/password/reset', 'ForgotPasswordController@show')->name('password.request');
            Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email.perform');
            Route::get('/password/reset/{token}', 'ResetPasswordController@show')->name('password.reset');
            Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset.perform');
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

            /**
             * Card Routes
             */
            Route::group(['namespace' => 'Card'], function () {
                Route::get('/order-new-card', 'OrderNewCardController@show')->name('card.ordernewcard.show');
                Route::post('/order-new-card', 'OrderNewCardController@order')->name('card.ordernewcard.perform');
            });

            /**
             * Wallet Routes
             */
            Route::group(['namespace' => 'Wallet'], function () {
                Route::get('/wallet/{id}', 'WalletController@show')->name('wallet.show');
                Route::post('/wallet/{id}', 'WalletController@payment')->name('wallet.payment.perform');


                Route::get('/create-wallet', 'CreateWalletController@show')->name('wallet.create.show');
                Route::post('/create-wallet', 'CreateWalletController@create')->name('wallet.create.perform');

                Route::get('/my-wallets', 'MyWalletsController@show')->name('wallet.mywallets.show');

                
                Route::get('/wallet-general-transactions', 'WalletGeneralTransactionsController@show')->name('wallet.generaltransactions.show');
            });
        });
    });

});
