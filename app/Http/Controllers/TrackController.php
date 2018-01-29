<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Post;
use App\Track;
use App\User;
use Auth;
use FFMpeg\FFMpeg;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

ini_set('max_execution_time', '300');

class TrackController extends Controller {
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

    public function postUploadTrack(Request $request) {
        // validation
        $this->validate($request, [
            'c_szam' => 'required',
            'c_cim' => 'required',
            'c_eloado' => 'required',
            'c_album' => 'required',
            'n_kiadev' => 'required',
        ], [
            'c_szam.required' => 'You have to choose a song to upload.',
            'c_cim.required' => 'Track title is required.',
            'c_eloado.required' => 'Artist name is required.',
            'c_album.required' => 'Album name is required.',
            'n_kiadev.required' => 'Release year is required.'
        ]);

        $user = Auth::user();
        $track = new Track();

        // generating track name
        $track_extension = $request->file('c_szam')->getClientOriginalExtension();
        $track_name = $this->generateRandomString(20).'.'.$track_extension;

        // generating cover name
        if($request->hasFile('c_borito')) {
            $cover_extension = $request->file('c_borito')->getClientOriginalExtension();
            $cover_name = $this->generateRandomString(12).'.'.$cover_extension;
        } else {
            $cover_name = 'nocover.jpg';
        }

        // saving data
        $track->n_felhid = $user->id;
        $track->c_cim = $request['c_cim'];
        $track->c_eloado = $request['c_eloado'];
        $track->c_album = $request['c_album'];
        $track->c_zenenev = $track_name;
        $track->c_zenelink = str_slug($request['c_cim'], '-');
        $track->c_boritonev = $cover_name;
        $track->n_kiadev = (int)$request['n_kiadev'];
        $track->c_leiras = $request['c_leiras'];
        $track->n_mufajazon = (int)$request['n_mufajazon'];

        $track->save();

        // creating directory
        $track = Track::where('n_felhid', $user->id)->orderBy('id', 'desc')->first();
        Storage::disk('users')->makeDirectory($user->c_felhnev.'/uploads/'.$track->id);
        $track_folder = $user->c_felhnev.'/uploads/'.$track->id;
        $track_file = $request->file('c_szam');
        $cover_file = $request->file('c_borito');

        // inserting track
        Storage::disk('users')->put($track_folder.'/'.$track_name, File::get($track_file));
        $full_path = storage_path().'\\users\\'.$user->c_felhnev.'\\uploads\\'.$track->id;

        // changing bitrate from 320kbps to 192kbps
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
            'timeout' => 0
        ]);

        // for debugging purposes
        /*$ffmpeg->getFFMpegDriver()->listen(new \Alchemy\BinaryDriver\Listeners\DebugListener());
        $ffmpeg->getFFMpegDriver()->on('debug', function ($message) {
            echo $message."\n";
        });*/
        $audio = $ffmpeg->open($full_path.'\\'.$track_name);
        $format = new \FFMpeg\Format\Audio\Mp3();
        $format->setAudioKiloBitrate(160);
        $audio->save($format, storage_path().'\\'.$track_name); // copying it to elsewhere, because replacing does not work

        // deleting the original file
        $this->deleteFiles($full_path.'\\*', 'mp3');

        // replacing with the converted file
        rename(storage_path().'\\'.$track_name, $full_path.'\\'.$track_name);

        // inserting cover
        if($cover_name == 'nocover.jpg') {
            $orig = storage_path().'\\pub\\nocover.jpg';
            $dest = storage_path().'\\users\\'.$user->c_felhnev.'\\uploads\\'.$track->id.'\\nocover.jpg';

            if(copy($orig, $dest)) {}
        } else {
            Storage::disk('users')->put($track_folder.'/'.$cover_name, File::get($cover_file));
        }

        Session::flash("message", "Song was successfully uploaded!");

        return "success";
    }

    public function postEditTrack(Request $request, $track_id) {
        // validation
        $this->validate($request, [
            'c_cim' => 'required',
            'c_eloado' => 'required',
            'c_album' => 'required',
            'n_kiadev' => 'required',
        ], [
            'c_cim.required' => 'Track title is required.',
            'c_eloado.required' => 'Artist name is required.',
            'c_album.required' => 'Album name is required.',
            'n_kiadev.required' => 'Release year is required.'
        ]);

        $track = Track::find($track_id);
        $user = Auth::user();

        // if avatar changed
        if($request['avatar-changed'] == "true") {
            // delete old cover
            $track_folder = storage_path().'\\users\\'.$user->c_felhnev.'\\uploads\\'.$track->id;
            $this->deleteFiles($track_folder.'\\*', 'jpg');

            if($request->hasFile('c_borito')) {
                $cover_extension = $request->file('c_borito')->getClientOriginalExtension();
                $cover_name = $this->generateRandomString(12).'.'.$cover_extension;
                $cover_file = $request->file('c_borito');

                Storage::disk('users')->put($user->c_felhnev.'/uploads/'.$track->id.'/'.$cover_name, File::get($cover_file));
            } else {
                $cover_name = 'nocover.jpg';
                $orig = storage_path().'\\pub\\nocover.jpg';
                $dest = $track_folder.'\\nocover.jpg';

                if(copy($orig, $dest)) {}
            }

            $track->c_boritonev = $cover_name;
        }

        // saving data
        $track->c_cim = $request['c_cim'];
        $track->c_eloado = $request['c_eloado'];
        $track->c_album = $request['c_album'];
        $track->n_kiadev = (int)$request['n_kiadev'];
        $track->c_leiras = $request['c_leiras'];
        $track->n_mufajazon = (int)$request['n_mufajazon'];

        $track->update();

        Session::flash('message', 'Song modifications are saved.');

        return "success";
    }

    public function getRemoveTrack($track_id) {
        $track = Track::where('id', $track_id)->first();
        $uploader = User::where('id', $track->n_felhid)->first();
        $user = Auth::user();

        if($uploader != $user) {
            return redirect('dashboard')->with([
                'message' => 'You have no access to the page.'
            ]);
        }

        // deleting files from the directory and then the directory itself
        $path = storage_path().'\\users\\'.$user->c_felhnev.'\\uploads\\'.$track_id;
        $this->deleteFiles($path.'\\*');
        rmdir($path);

        // deleting rows from the database
        $posts_to_delete = Post::where('n_szam_id', $track_id)->pluck('id')->toArray();
        Favorite::whereIn('n_tipus_id', $posts_to_delete)->where('c_tipus', 'post')->delete();
        Favorite::where([['n_tipus_id', '=', $track_id], ['c_tipus', '=', 'track']])->delete();
        Post::whereIn('id', $posts_to_delete)->delete();
        $track->delete();

        return redirect()->route('dashboard')->with([
            'message' => 'The song was successfully deleted.'
        ]);
    }

    public function getTrackCover($filename) {
        $track = Track::where('c_boritonev', $filename)->first();
        $user = User::where('id', $track->n_felhid)->first();
        $file = Storage::disk('users')->get($user->c_felhnev.'/uploads/'.$track->id.'/'.$filename);

        return new Response($file, 200);
    }

    public function getTrackData($filename) {
        $track = Track::where('c_zenenev', $filename)->first();
        $user = User::where('id', $track->n_felhid)->first();
        $file = Storage::disk('users')->get($user->c_felhnev.'/uploads/'.$track->id.'/'.$filename);

        return new Response($file, 200);
    }
}