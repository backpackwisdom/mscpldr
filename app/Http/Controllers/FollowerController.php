<?php

namespace App\Http\Controllers;

use App\Follower;
use App\User;
use Auth;
use Illuminate\Support\Facades\Session;

class FollowerController extends Controller {
    public function postAddFollower($followed_id) {
        $follower_user = Auth::user();
        $followed_user = User::where('id', $followed_id)->first();

        $follower = new Follower();
        $follower->c_koveto = $follower_user->id;
        $follower->c_kovetett = $followed_id;
        $follower->save();

        Session::flash('message', 'You\'re now following '.$followed_user->c_felhnev.'.');

        return "success";
    }

    public function postRemoveFollower($followed_id) {
        $follower_user = Auth::user();
        $followed_user = User::where('id', $followed_id)->first();

        $follower = Follower::where([
            ['c_koveto', '=', $follower_user->id],
            ['c_kovetett', '=', $followed_user->id]
        ])->first();

        $follower->delete();

        Session::flash('message', 'You\'re now unsubscribed from following '.$followed_user->c_felhnev.'\'s content.');

        return "success";
    }
}