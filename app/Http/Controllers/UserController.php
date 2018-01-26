<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class UserController extends Controller {
    public function generateRandomString($user_id, $length = 10) {
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

    public function postSignUpData(Request $request) {
        // form validation
        $this->validate($request, [
            'c_email' => 'required|email|max:100|unique:users,c_email',
            'c_username' => 'required|min:4|max:16|unique:users,c_felhnev',
            'c_password' => 'required|min:6|regex:/^(?=.*?\d)(?=.*?[a-zA-Z])[a-zA-Z\d]+$/',
            'c_passconf' => 'required|same:c_password'
        ], [
            'c_email.required' => 'Email address is required.',
            'c_email.email' => 'Invalid email address.',
            'c_email.max' => 'Email address cannot be longer than 100 characters.',
            'c_email.unique' => 'Email address is already taken.',
            'c_username.required' => 'Username is required.',
            'c_username.min' => 'Username length must be between 4 and 16 characters.',
            'c_username.max' => 'Username length must be between 4 and 16 characters.',
            'c_username.unique' => 'Username is already taken.',
            'c_password.required' => 'Password is required.',
            'c_password.min' => 'Password must be at least 6 characters long.',
            'c_password.regex' => 'Password must contain both letters and numbers.',
            'c_passconf.required' => 'You must confirm your password.',
            'c_passconf.same' => 'Password confirmation is wrong.',
        ]);

        // creating new user
        $user = new User();
        $user->c_felhnev = $request['c_username'];
        $user->c_jelszo = bcrypt($request['c_password']);
        $user->c_email = $request['c_email'];

        $user->save();

        // creating user directory and subdirectories
        Storage::disk('users')->makeDirectory($user->c_felhnev);
        Storage::disk('users')->makeDirectory($user->c_felhnev . '/avatar');
        Storage::disk('users')->makeDirectory($user->c_felhnev . '/uploads');

        // copy default avatar
        $orig = storage_path().'\\pub\\noavatar.jpg';
        $dest = storage_path().'\\users\\'.$user->c_felhnev.'\\avatar\\noavatar.jpg';

        if(copy($orig, $dest)) {
            // send success message
            Session::flash('message', 'Successful sign up!');

            return "success";
        }
    }

    public function postSignInData(Request $request) {
        $this->validate($request, [
            'c_username' => 'required',
            'c_password' => 'required'
        ], [
            'c_username.required' => 'Username is required.',
            'c_password.required' => 'Password is required.'
        ]);

        if(Auth::attempt([
            'c_felhnev' => $request['c_username'],
            'password' => $request['c_password']
        ])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }

    public function getLogout() {
        Auth::logout();

        return redirect()->route('home');
    }

    public function getAccountData() {
        return view('settings', [
            'user' => Auth::user()
        ]);
    }

    public function postAccountData(Request $request) {
        $user = Auth::user();
        dd($request);

        switch($request['button']) {
            // form submitting
            case 'submit':
                $this->validate($request, [
                    'c_email' => 'required|email|unique:users,c_email,' . $user->id,
                    'c_avatarlink' => 'mimes:jpeg,png'
                ], [
                    'c_email.required' => 'Email address is required.',
                    'c_email.email' => 'Email address is invalid.',
                    'c_email.unique' => 'Email address is already taken.',
                    'c_avatarlink.mimes' => 'Invalid picture format.'
                ]);

                $user->c_email = $request['c_email'];

                if($request->hasFile('c_avatarlink')) {
                    // generate file name and get file extension
                    $randstr = $this->generateRandomString($user->id);
                    $fileext = $request->file('c_avatarlink')->getClientOriginalExtension();
                    $file = $request->file('c_avatarlink');
                    $filename = $randstr . '.' . $fileext;

                    $user->c_avatarlink = $filename;

                    // personal folder
                    $userfolder = $user->c_felhnev.'/avatar';

                    // inserting/updating avatar
                    $avatar_dir_files = Storage::disk('users')->allFiles($userfolder);

                    if(!empty($avatar_dir_files)) {
                        $this->deleteFiles(storage_path('users\\'.$user->c_felhnev.'\\avatar\\*'));
                    }

                    Storage::disk('users')->put($userfolder.'/'.$filename, File::get($file));
                }
            break;

            // removing avatar
            case 'remove-avatar':
                $user->c_avatarlink = 'noavatar.jpg';

                $this->deleteFiles(storage_path('users\\'.$user->c_felhnev.'\\avatar\\*'));

                // copy default avatar
                $orig = storage_path().'\\pub\\noavatar.jpg';
                $dest = storage_path().'\\users\\'.$user->c_felhnev.'\\avatar\\noavatar.jpg';

                if(copy($orig, $dest)) {}
            break;
        }

        $user->update();

        Session::flash('message', 'Profile successfully updated!');

        return "success";
    }

    public function getUserAvatar($user_id, $filename) {
        $user = User::where('id', $user_id)->first();
        $file = Storage::disk('users')->get($user->c_felhnev . '/avatar/' . $filename);

        return new Response($file, 200);
    }

    public function postChangePassword(Request $request) {
        $this->validate($request, [
            'c_password_old' => 'required|check_cur_pw',
            'c_password_new' => 'required|different:c_password_old|min:6|regex:/^(?=.*?\d)(?=.*?[a-zA-Z])[a-zA-Z\d]+$/',
            'c_passconf_new' => 'required|same:c_password_new'
        ], [
            'c_password_old.required' => 'Please type in your old password.',
            'c_password_old.check_cur_pw' => 'Incorrent old password.',
            'c_password_new.required' => 'Please type in your new password.',
            'c_password_new.different' => 'The old and the new password should be different.',
            'c_password_new.min' => 'Password must be at least 6 characters long.',
            'c_password_new.regex' => 'Password must contain both letters and numbers.',
            'c_passconf_new.required' => 'Please confirm your new password.',
            'c_passconf_new.same' => 'Password confirmation is wrong.',
        ]);

        $user = Auth::user();
        $user->c_jelszo = bcrypt($request['c_password_new']);
        $user->update();

        Session::flash('message', 'Password is renewed! Please try to log in again with your new password.');

        return "success";
    }
}