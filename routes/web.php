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

Route::group(['middleware' => ['web']], function() {
    // authenticated and guest users both
    Route::get('/useravatar/{user_id}/{filename}', [
        'uses' => 'UserController@getUserAvatar',
        'as' => 'avatar.get'
    ]);

    Route::get('/profile/{user_id}', [
        'uses' => 'PageController@getProfilePage',
        'as' => 'user.get'
    ]);

    // authenticated users
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/dashboard', [
            'uses' => 'PageController@getDashboardPage',
            'as' => 'dashboard',
        ]);

        Route::get('/logout', [
            'uses' => 'UserController@getLogout',
            'as' => 'logout',
        ]);

        Route::get('/upload', [
            'uses' => 'PageController@getUploadPage',
            'as' => 'upload.get'
        ]);

        Route::get('/settings', [
            'uses' => 'UserController@getAccountData',
            'as' => 'settings.get'
        ]);

        Route::get('/pw-change', [
            'uses' => 'PageController@getPasswordChangePage',
            'as' => 'pw-change.get'
        ]);

        Route::get('/followed', [
            'uses' => 'PageController@getSubscriptionsPage',
            'as' => 'followed.get'
        ]);

        Route::post('/settings', [
            'uses' => 'UserController@postAccountData',
            'as' => 'settings.post'
        ]);

        Route::post('/pw-change', [
            'uses' => 'UserController@postChangePassword',
            'as' => 'pw-change.post'
        ]);

        Route::post('/add-follower/{followed_id}', [
            'uses' => 'FollowerController@postAddFollower',
            'as' => 'follower.add'
        ]);

        Route::post('/remove-follower/{followed_id}', [
            'uses' => 'FollowerController@postRemoveFollower',
            'as' => 'follower.remove'
        ]);
    });

    // guest users
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/', function () {
            return view('welcome');
        })->name('home');

        Route::get('/signup', [
            'uses' => 'PageController@getSignUpPage',
            'as' => 'signup.get',
        ]);

        Route::post('/signup', [
            'uses' => 'UserController@postSignUpData',
            'as' => 'signup.post'
        ]);

        Route::post('/signin', [
            'uses' => 'UserController@postSignInData',
            'as' => 'signin.post'
        ]);
    });
});
