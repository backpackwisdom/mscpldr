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

    Route::get('track/{track_id}/{track_slug}', [
        'uses' => 'PageController@getTrackPage',
        'as' => 'track.get'
    ]);

    Route::get('album/{album_id}/{album_slug}', [
        'uses' => 'PageController@getAlbumPage',
        'as' => 'album.get'
    ]);

    Route::get('track-cover/{filename}', [
        'uses' => 'TrackController@getTrackCover',
        'as' => 'track.cover'
    ]);

    Route::get('album-cover/{filename}', [
        'uses' => 'AlbumController@getAlbumCover',
        'as' => 'album.cover'
    ]);

    Route::get('track/{filename}', [
        'uses' => 'TrackController@getTrackData',
        'as' => 'track.content'
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

        Route::get('/track-edit/{track_id}', [
            'uses' => 'PageController@getEditTrack',
            'as' => 'track-edit.get'
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

        Route::post('/upload', [
            'uses' => 'TrackController@postUploadTrack',
            'as' => 'upload.post'
        ]);

        Route::post('/track-edit/{track_id}', [
            'uses' => 'TrackController@postEditTrack',
            'as' => 'track-edit.post'
        ]);

        Route::get('/track-remove/{track_id}', [
            'uses' => 'TrackController@getRemoveTrack',
            'as' => 'track-remove.get'
        ]);

        Route::post('/post-create/{post_type}/{type_id}', [
            'uses' => 'PostController@postCreatePost',
            'as' => 'post.create'
        ]);

        Route::get('/post-remove/{post_id}', [
            'uses' => 'PostController@getDeletePost',
            'as' => 'post.remove'
        ]);

        Route::get('/add-favorite/{fav_type}/{type_id}', [
            'uses' => 'FavoriteController@postAddFavorite',
            'as' => 'favorite.add'
        ]);

        Route::get('/remove-favorite/{fav_type}/{type_id}', [
            'uses' => 'FavoriteController@postRemoveFavorite',
            'as' => 'favorite.remove'
        ]);

        Route::get('/create-album', [
            'uses' => 'PageController@getAlbumCreatePage',
            'as' => 'album-create.get'
        ]);

        Route::post('/create-album', [
            'uses' => 'AlbumController@postCreateAlbum',
            'as' => 'album-create.post'
        ]);

        Route::get('/edit-album/{album_id}', [
            'uses' => 'PageController@getEditAlbum',
            'as' => 'album-edit.get'
        ]);

        Route::post('/edit-album/{album_id}', [
            'uses' => 'AlbumController@postEditAlbum',
            'as' => 'album-edit.post'
        ]);

        Route::get('/remove-album/{album_id}', [
            'uses' => 'AlbumController@getRemoveAlbum',
            'as' => 'album.remove'
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
