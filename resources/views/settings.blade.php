@extends('layouts.master')

@section('title')
    Profile settings
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')
    <p>You can change your account settings here.</p>

    <form action="{{ route('settings.post') }}" method="post" id="form-account" enctype="multipart/form-data">
        <div>
            <label for="c_username">Username</label><br>
            <input type="text" name="c_username" value="{{ $user->c_felhnev }}" disabled="disabled">
        </div>
        <div>
            <label for="c_email">Email</label><br>
            <input type="text" name="c_email" value="{{ $user->c_email }}">
        </div>
        <div>
            <label for="c_avatarlink">Avatar</label><br>
            <input type="file" name="c_avatarlink">
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button type="submit" name="submitbutton" value="submit">Save changes</button>
        <button type="submit" name="submitbutton" value="remove-avatar" {{ ($user->c_avatarlink) == 'noavatar.jpg' ? "style=display:none;" : "" }}>Remove avatar</button>
    </form>

    <img src="{{ route('avatar.get', ['user_id' => $user->id, 'filename' => $user->c_avatarlink]) }}" width="100" height="100">

    @include('includes.footer')
@endsection

@section('page-js')
    <script>
        var url = '{{ route('settings.post') }}';
    </script>
    <script src="{{ URL::to('js/changeacc.js') }}"></script>
@endsection