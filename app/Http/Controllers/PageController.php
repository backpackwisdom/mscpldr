<?php

namespace App\Http\Controllers;

use App\Album;
use App\Albumtrack;
use App\Favorite;
use App\Post;
use DB;
use Auth;
use App\Follower;
use App\User;
use App\Genre;
use App\Track;
use Illuminate\Support\Facades\Session;

class PageController extends Controller {
    public function getHomePage() {
        $latest_tracks = Track::orderBy('id', 'desc')->take(10)->get();
        $count_latest_tracks = Track::orderBy('id', 'desc')->take(10)->count();

        return view('welcome', [
            'tracks' => $latest_tracks,
            'count_tracks' => $count_latest_tracks
        ]);
    }

    public function getProfilePage($user_id) {
        $user = User::where('id', $user_id)->first();
        $auth_user = Auth::user();

        if(!$auth_user) {
            Session::flash('error', 'You need to log in to get this page first.');

            return redirect()->route('home');
        }

        // check if the authenticated user follows the current user
        $following = !empty(Follower::where([
            ['c_koveto', '=', $auth_user->id],
            ['c_kovetett', '=', $user_id]
        ])->first());

        return view('profile', [
            'user' => $user,
            'following' => $following
        ]);
    }

    public function getSignUpPage() {
        return view('signup');
    }

    public function getDashboardPage() {
        $latest_users = User::orderBy('id', 'desc')->take(10)->get();
        $count_latest_users = User::orderBy('id', 'desc')->take(10)->count();
        $latest_tracks = Track::orderBy('id', 'desc')->take(10)->get();
        $count_latest_tracks = Track::orderBy('id', 'desc')->take(10)->count();
        $latest_albums = Album::orderby('id', 'desc')->take(10)->get();
        $count_latest_albums = Album::orderby('id', 'desc')->take(10)->count();

        return view('dashboard', [
            'users' => $latest_users,
            'count_users' => $count_latest_users,
            'tracks' => $latest_tracks,
            'count_tracks' => $count_latest_tracks,
            'albums' => $latest_albums,
            'count_albums' => $count_latest_albums
        ]);
    }

    public function getUploadPage() {
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();

        return view('upload', [
            'genres' => $genres
        ]);
    }

    public function getAlbumCreatePage() {
        $user = Auth::user();
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();
        $tracks = Track::where('n_felhid', $user->id)->get();

        return view('album-create', [
            'tracks' => $tracks,
            'genres' => $genres
        ]);
    }

    public function getPasswordChangePage() {
        return view('pw-change');
    }

    public function getSubscriptionsPage() {
        $auth_user = Auth::user();

        $followed = DB::table('followers')
            ->join('users', 'followers.c_kovetett', '=', 'users.id')
            ->select('users.*')
            ->where('followers.c_koveto', '=', $auth_user->id)
            ->orderBy('users.c_felhnev', 'asc')
            ->get();

        $followers = DB::table('followers')
            ->join('users', 'followers.c_koveto', '=', 'users.id')
            ->select('users.*')
            ->where('followers.c_kovetett', '=', $auth_user->id)
            ->orderBy('users.c_felhnev', 'asc')
            ->get();

        return view('subscriptions', [
            'followed' => $followed,
            'followers' => $followers
        ]);
    }

    public function getTrackPage($track_id, $track_slug) {
        $track = Track::where('id', $track_id)->first();
        $user = User::where('id', $track->n_felhid)->first();
        $auth_user = Auth::user();

        $track_fav_count = Favorite::where([
            ['c_tipus', '=', 'track'],
            ['n_tipus_id', '=', $track_id]
        ])->count();

        if($auth_user) {
            $track_is_fav = Favorite::where([
                ['c_tipus', '=', 'track'],
                ['n_tipus_id', '=', $track_id],
                ['n_felh_id', '=', $auth_user->id]
            ])->count();

            // if authenticated: posts + favorites for the current user
            $posts = DB::select('
          select posts.*, users.c_felhnev, favorites.d_jelol_datum 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
                left join 
              favorites on favorites.n_tipus_id = posts.id and favorites.c_tipus = ? and favorites.n_felh_id = ? 
           where posts.c_tipus = \'track\' and posts.n_tipus_id = ?
           order by posts.created_at desc',
                ['post', $auth_user->id, $track_id]
            );
        } else {
            $track_is_fav = null;
            // if not, just posts
            $posts = DB::select('
          select posts.*, users.c_felhnev 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
           where posts.c_tipus = \'track\' and posts.n_tipus_id = ?
           order by posts.created_at desc',
                [$track_id]
            );
        }

        return view('track', [
            'track' => $track,
            'track_fav_count' => $track_fav_count,
            'track_is_fav' => $track_is_fav,
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function getEditTrack($track_id) {
        $track = Track::where('id', $track_id)->first();
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();
        $user = User::where('id', $track->n_felhid)->first();

        if($user != Auth::user()) {
            return redirect()->with([
                'message' => 'You have no access to the page.'
            ]);
        }

        return view('track-edit', [
            'track' => $track,
            'genres' => $genres
        ]);
    }

    public function getAlbumPage($album_id, $album_slug) {
        $album = Album::where('id', $album_id)->first();
        $tracks_to_display = Albumtrack::where('n_album_id', $album_id)->pluck('n_szam_id')->toArray();
        $tracks = Track::whereIn('id', $tracks_to_display)->get();
        $user = User::where('id', $album->n_felh_id)->first();
        $genre = Genre::where('id', $album->n_mufaj_id)->first();
        $auth_user = Auth::user();

        $album_fav_count = Favorite::where([
            ['c_tipus', '=', 'album'],
            ['n_tipus_id', '=', $album_id]
        ])->count();

        if($auth_user) {
            $album_is_fav = Favorite::where([
                ['c_tipus', '=', 'album'],
                ['n_tipus_id', '=', $album_id],
                ['n_felh_id', '=', $auth_user->id]
            ])->count();

            // if authenticated: posts + favorites for the current user
            $posts = DB::select('
          select posts.*, users.c_felhnev, favorites.d_jelol_datum 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
                left join 
              favorites on favorites.n_tipus_id = posts.id and favorites.c_tipus = ? and favorites.n_felh_id = ? 
           where posts.c_tipus = \'album\' and posts.n_tipus_id = ?
           order by posts.created_at desc',
                ['post', $auth_user->id, $album_id]
            );
        } else {
            $album_is_fav = null;
            // if not, just posts
            $posts = DB::select('
          select posts.*, users.c_felhnev 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
           where posts.c_tipus = \'album\' and posts.n_tipus_id = ?
           order by posts.created_at desc',
                [$album_id]
            );
        }

        return view('album', [
            'album' => $album,
            'tracks' => $tracks,
            'user' => $user,
            'genre' => $genre,
            'album_is_fav' => $album_is_fav,
            'album_fav_count' => $album_fav_count,
            'posts' => $posts
        ]);
    }

    public function getEditAlbum($album_id) {
        $album = Album::where('id', $album_id)->first();
        $albumtracks = Albumtrack::where('n_album_id', $album_id)->pluck('n_szam_id')->toArray();
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();
        $user = User::where('id', $album->n_felh_id)->first();
        $tracks = Track::where('n_felhid', $user->id)->get();

        if($user != Auth::user()) {
            return redirect()->with([
                'message' => 'You have no access to the page.'
            ]);
        }

        return view('album-edit', [
            'album' => $album,
            'albumtracks' => $albumtracks,
            'tracks' => $tracks,
            'genres' => $genres
        ]);
    }
}