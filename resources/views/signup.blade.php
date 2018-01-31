@extends('layouts.master')

@section('title')
    Sign up
@endsection

@section('content')
    @include('includes.message')
    <p>After signing up, you'll be redirected to the home page to log in.</p>
    <form action="{{ route('signup.post') }}" method="post" id="form-signup">
        <div>
            <label for="Email">Email</label><br>
            <input type="text" name="c_email" value="{{ Request::old('c_email') }}">
        </div>
        <div>
            <label for="username">Username</label><br>
            <input type="text" name="c_username" value="{{ Request::old('c_username') }}">
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="c_password">
        </div>
        <div>
            <label for="passconf">Password confirm</label><br>
            <input type="password" name="c_passconf">
        </div>
        <button type="submit">Submit</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('signup.post') }}';
        var base_url = '<?php echo url('/'); ?>';
    </script>
    <script src="{{ URL::to('js/signup.js') }}"></script>
@endsection