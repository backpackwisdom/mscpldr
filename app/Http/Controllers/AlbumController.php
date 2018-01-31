<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Albumtrack;
use App\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller {
    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public function deleteFiles($dir_path, $ext = null) {
        $files = glob($dir_path);

        foreach($files as $file) {
            if(is_file($file)) {
                if($ext != null) {
                    // delete files with certain extension
                    $path = pathinfo($file);
                    if($path['extension'] == $ext) {
                        unlink($file);
                    }
                } else {
                    // delete all files
                    unlink($file);
                }
            }
        }
    }

    public function postCreateAlbum(Request $request) {
        // validation
        $this->validate($request, [
            'c_albumszamok' => 'required',
            'c_albumnev' => 'required|max:256',
            'c_eloado' => 'required|max:256',
            'n_kiadev' => 'required'
        ], [
            'c_albumszamok.required' => 'You have to choose at least one track for the album.',
            'c_albumnev.required' => 'The name of the album is required.',
            'c_albumnev.max' => 'The length of album name must not be larger than 256 chars.',
            'c_eloado.required' => 'The name of the artist is required.',
            'c_eloado.max' => 'The length of artist name must not be larger than 256 chars.',
            'n_kiadev.required' => 'The year of release is required.'
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $album = new Album();

            // generating album cover
            if($request->hasFile('c_borito')) {
                $cover_extension = $request->file('c_borito')->getClientOriginalExtension();
                $cover_name = $this->generateRandomString(12).'.'.$cover_extension;
            } else {
                $cover_name = 'nocover.jpg';
            }

            // saving data
            $album->n_felh_id = $user->id;
            $album->c_albumnev = $request['c_albumnev'];
            $album->c_eloado = $request['c_eloado'];
            $album->n_kiadev = (int)$request['n_kiadev'];
            $album->c_albumlink = str_slug($request['c_albumnev']);
            $album->c_boritonev = $cover_name;
            $album->c_leiras = $request['c_leiras'];
            $album->n_mufaj_id = (int)$request['n_mufajazon'];

            $album->save();

            // creating directory
            $album = Album::where('n_felh_id', $user->id)->orderBy('created_at', 'desc')->first();
            Storage::disk('albums')->makeDirectory($album->id);

            // saving cover
            if($cover_name == 'nocover.jpg') {
                $orig = storage_path().'\\pub\\nocover.jpg';
                $dest = storage_path().'\\albums\\'.$album->id.'\\nocover.jpg';

                if(copy($orig, $dest)) {}
            } else {
                $cover_file = $request->file('c_borito');
                Storage::disk('albums')->put($album->id.'/'.$cover_name, File::get($cover_file));
            }

            // assigning tracks to the album
            foreach($request['c_albumszamok'] as $item) {
                $albumtracks = new Albumtrack();

                $albumtracks->n_album_id = $album->id;
                $albumtracks->n_szam_id = (int)$item;

                $albumtracks->save();
            }

            // committing all changes
            DB::commit();

            Session::flash('message', 'Your album has been successfully created.');

            return "success";
        } catch (\Exception $e) {
            // delete album folder if created
            $album = Album::where('n_felh_id', $user->id)->orderBy('created_at', 'desc')->first();

            if(!empty($album)) {
                $dir_to_delete = storage_path().'\\albums\\'.$album->id;

                if(file_exists($dir_to_delete)) {
                    $this->deleteFiles($dir_to_delete.'\\*', 'jpg');
                    rmdir($dir_to_delete);
                }
            }

            // rollback transaction if error happens
            DB::rollback();
        }
    }

    public function postEditAlbum(Request $request, $album_id) {
        // validation
        $this->validate($request, [
            'c_albumszamok' => 'required',
            'c_albumnev' => 'required|max:256',
            'c_eloado' => 'required|max:256',
            'n_kiadev' => 'required'
        ], [
            'c_albumszamok.required' => 'You have to choose at least one track for the album.',
            'c_albumnev.required' => 'The name of the album is required.',
            'c_albumnev.max' => 'The length of album name must not be larger than 256 chars.',
            'c_eloado.required' => 'The name of the artist is required.',
            'c_eloado.max' => 'The length of artist name must not be larger than 256 chars.',
            'n_kiadev.required' => 'The year of release is required.'
        ]);

        $user = Auth::user();
        $album = Album::where('id', $album_id)->first();

        DB::beginTransaction();

        try {
            // if tracklist changed
            $albumtracks = Albumtrack::where('n_album_id', $album_id)->pluck('n_szam_id')->toArray();

            if($request['c_albumszamok'] != $albumtracks) {
                // delete all previous tracks
                Albumtrack::where('n_album_id', $album->id)->delete();

                // assigning tracks to the album
                foreach($request['c_albumszamok'] as $item) {
                    $albumtracks = new Albumtrack();

                    $albumtracks->n_album_id = $album->id;
                    $albumtracks->n_szam_id = (int)$item;

                    $albumtracks->save();
                }
            }

            // if avatar changed
            if($request['avatar-changed'] == "true") {
                // delete old cover
                $album_folder = storage_path().'\\albums\\'.$album_id;
                $this->deleteFiles($album_folder.'\\*', 'jpg');

                if($request->hasFile('c_borito')) {
                    $cover_extension = $request->file('c_borito')->getClientOriginalExtension();
                    $cover_name = $this->generateRandomString(12).'.'.$cover_extension;
                    $cover_file = $request->file('c_borito');

                    Storage::disk('albums')->put($album_id.'/'.$cover_name, File::get($cover_file));
                } else {
                    $cover_name = 'nocover.jpg';
                    $orig = storage_path().'\\pub\\nocover.jpg';
                    $dest = $album_folder.'\\nocover.jpg';

                    if(copy($orig, $dest)) {}
                }

                $album->c_boritonev = $cover_name;
            }

            // saving data
            $album->c_albumnev = $request['c_albumnev'];
            $album->c_eloado = $request['c_eloado'];
            $album->n_kiadev = (int)$request['n_kiadev'];
            $album->c_albumlink = str_slug($request['c_albumnev']);
            $album->c_leiras = $request['c_leiras'];
            $album->n_mufaj_id = (int)$request['n_mufajazon'];

            $album->update();

            DB::commit();

            Session::flash('message', 'Album modifications are saved.');

            return "success";
        } catch (\Exception $e) {
            // rollback on error
            DB::rollback();

            $album_folder = storage_path().'\\albums\\'.$album->id;
            $this->deleteFiles($album_folder.'\\*');
            $cover_name = 'nocover.jpg';
            $orig = storage_path().'\\pub\\nocover.jpg';
            $dest = $album_folder.'\\nocover.jpg';

            if(copy($orig, $dest)) {
                $album->c_boritonev = $cover_name;
            }

            $album->update();
        }
    }

    public function getRemoveAlbum($album_id) {
        Albumtrack::where('n_album_id', $album_id)->delete();
        Album::where('id', $album_id)->delete();

        // delete folder + cover
        $dir_to_delete = storage_path().'\\albums\\'.$album_id;
        $this->deleteFiles($dir_to_delete.'\\*');
        rmdir($dir_to_delete);

        return redirect()->route('dashboard')->with([
            'message' => 'Album is successfully deleted.'
        ]);
    }

    public function getAlbumCover($filename) {
        $album = Album::where('c_boritonev', $filename)->first();
        $file = Storage::disk('albums')->get($album->id.'/'.$filename);

        return new Response($file, 200);
    }
}