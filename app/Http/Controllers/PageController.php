<?php

namespace App\Http\Controllers;

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

        return view('track', [
            'track' => $track,
            'user' => $user
        ]);
    }

    public function getEditTrack($track_id) {
        $track = Track::where('id', $track_id)->first();
        $genres = Genre::orderBy('c_mufajnev', 'asc')->get();

        return view('track-edit', [
            'track' => $track,
            'genres' => $genres
        ]);
    }
}