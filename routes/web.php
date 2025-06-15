<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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

        Route::get('/run/{method}', function ($method) {
            if (Auth::user()->role !== 1) {
                abort(500);
            }

            switch ($method) {
                case 'all':
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', ['--force' => true]);
                    return response()->json(['status' => 'success', 'message' => 'Migrations and seeders executed.']);
                case 'migrate':
                    Artisan::call('migrate', ['--force' => true]);
                    return response()->json(['status' => 'success', 'message' => 'Migrations executed.']);
                case 'seed':
                    Artisan::call('db:seed', ['--force' => true]);
                    return response()->json(['status' => 'success', 'message' => 'Seeders executed.']);
                default:
                    abort(404);
            }
        })->name('run.method');

        Route::group(['middleware' => ['verified']], function () {
            // Onaylı hesaplar

            Route::get('/', 'HomeController@show')->name('home.show');
            Route::get('/dashboard', 'DashboardController@show')->name('dashboard.show');

            /**
             * Card Routes
             */
            Route::group(['namespace' => 'Card'], function () {
                Route::get('/order-new-card', 'OrderNewCardController@show')->name('card.ordernewcard.show');
                Route::post('/order-new-card', 'OrderNewCardController@order')->name('card.ordernewcard.perform');

                Route::post('/card-request-cancel', 'CardRequestController@cancel')->name('card.request.cancel');
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

            /**
             * Event Routes
             */
            Route::group(['namespace' => 'Event'], function () {
                Route::get('/events', 'EventController@list')->name('events.list');

                Route::get('/events/{id}/view', 'EventController@show')->name('events.show');
                Route::post('/events/{id}/view/join', 'EventController@join_perform')->name('events.join.perform');
                Route::post('/events/{id}/view/leave', 'EventController@leave_perform')->name('events.leave.perform');
                Route::post('/events/{id}/view/payment', 'EventController@payment_perform')->name('events.payment.perform');

                Route::get('/events/{id}/edit', 'EventController@edit')->name('events.edit');
                Route::post('/events/{id}/edit', 'EventController@edit_perform')->name('events.edit.perform');
                Route::post('/events/{id}/delete', 'EventController@delete_perform')->name('events.delete.perform');

                Route::get('/events/create', 'EventController@create')->name('events.create');
                Route::post('/events/create', 'EventController@create_perform')->name('events.create.perform');
                
                Route::get('/events/participations', 'EventController@participations')->name('events.participations');
                Route::get('/events/history', 'EventController@history')->name('events.history');
                Route::post('/events/upload-media', 'EventController@uploadMedia')->name('events.uploadMedia');
            });
        });
    });

});
