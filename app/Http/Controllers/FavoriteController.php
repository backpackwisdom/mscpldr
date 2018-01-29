<?php

namespace App\Http\Controllers;

use Auth;
use App\Favorite;

class FavoriteController extends Controller {
    public function postAddFavorite($type_name, $type_id) {
        $user = Auth::user();
        $favorited = !empty(Favorite::where([
            ['c_tipus', '=', $type_name],
            ['n_tipus_id', '=', $type_id],
            ['n_felh_id', '=', $user->id]
        ])->first());

        if($favorited == true) {
            return redirect('dashboard')->with([
                'message' => 'You have no access to the page.'
            ]);
        }

        $favorite = new Favorite();

        $favorite->c_tipus = $type_name;
        $favorite->n_tipus_id = $type_id;
        $favorite->n_felh_id = $user->id;

        $favorite->save();

        return "success";
    }

    public function postRemoveFavorite($type_name, $type_id) {
        $user = Auth::user();

        $favorite = Favorite::where([
            ['c_tipus', '=', $type_name],
            ['n_tipus_id', '=', $type_id],
            ['n_felh_id', '=', $user->id]
        ])->first();

        $favorite->delete();

        return "success";
    }
}