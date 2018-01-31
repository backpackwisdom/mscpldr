@extends('layouts.master')

@section('title')
    Home
@endsection

@section('content')
    @include('includes.message')
    <p>Log in to start exploring!</p>
    <form action="{{ route('signin.post') }}" method="post" id="form-signin">
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="c_username" value="{{ Request::old('c_username') }}">
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="c_password">
        </div>
        <button type="submit">Log in</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>

    <p>Forgot your password? Enter your email to get a reminder.</p>
    <form action="#" method="post" id="form-pw-forgotten">
        <div>
            <input type="text" name="c_email" value="{{ Request::old('c_email') }}">
        </div>
        <button type="submit">Send</button>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('signin.post') }}';
    </script>
    <script src="{{ URL::to('js/signin.js') }}"></script>
@endsection