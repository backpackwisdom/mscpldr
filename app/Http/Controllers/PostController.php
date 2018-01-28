<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller {
    public function postCreatePost(Request $request, $track_id) {
        $this->validate($request, [
            'c_szoveg' => 'required|max:1000'
        ], [
            'c_szoveg.required' => 'The body of the post is required.',
            'c_szoveg.max' => 'The length of post must not be larger than 1000 chars.'
        ]);

        $post = new Post();
        $user = Auth::user();

        $post->n_felh_id = $user->id;
        $post->n_szam_id = $track_id;
        $post->c_szoveg = $request['c_szoveg'];

        $post->save();

        Session::flash('message', 'Your post has been successfully sent.');

        return "success";
    }

    public function getDeletePost($post_id) {
        $post = Post::where('id', $post_id)->first();
        $user = User::where('id', $post->n_felh_id)->first();

        if($user != Auth::user()) {
            return redirect('dashboard')->with([
                'message' => 'You have no access to this page.'
            ]);
        }

        $post->delete();

        return redirect()->back()->with([
            'message', 'Your post has been successfully deleted.'
        ]);
    }
}