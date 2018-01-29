<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Post;
use DB;
use Auth;
use App\Follower;
use App\User;
use App\Genre;
use App\Track;

class PageController extends Controller {
    public function getProfilePage($user_id) {
        $user = User::where('id', $user_id)->first();
        $auth_user = Auth::user();

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
        $latest_users = User::orderBy('id', 'desc')->take(5)->get();
        $latest_tracks = Track::orderBy('id', 'desc')->get();

        return view('dashboard', [
            'users' => $latest_users,
            'tracks' => $latest_tracks
        ]);
    }

    public function getUploadPage() {
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();

        return view('upload', [
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
        $track_is_fav = Favorite::where([
            ['c_tipus', '=', 'track'],
            ['n_tipus_id', '=', $track_id],
            ['n_felh_id', '=', $user->id]
        ])->count();

        $track_fav_count = Favorite::where([
            ['c_tipus', '=', 'track'],
            ['n_tipus_id', '=', $track_id]
        ])->count();

        if(Auth::user()) {
            // if authenticated: posts + favorites for the current user
            $posts = DB::select('
          select posts.*, users.c_felhnev, favorites.d_jelol_datum 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
                left join 
              favorites on favorites.n_tipus_id = posts.id and favorites.c_tipus = ? and favorites.n_felh_id = ? 
           where posts.n_szam_id = ?
           order by posts.created_at desc',
                ['post', Auth::user()->id, $track_id]
            );
        } else {
            // if not, just posts
            $posts = DB::select('
          select posts.*, users.c_felhnev 
            from 
              posts 
                join 
              users on posts.n_felh_id = users.id 
           where posts.n_szam_id = ?
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
}