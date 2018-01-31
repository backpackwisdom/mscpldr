@extends('layouts.master')

@section('title')
    Change password
@endsection

@section('content')
    @include('includes.message')
    <p>To change your password, please type in the right data.</p>

    <form action="{{ route('pw-change.post') }}" method="post" id="form-pw-change">
        <div>
            <label for="c_password_old">Old password</label><br>
            <input type="password" name="c_password_old">
        </div>
        <div>
            <label for="c_password_new">New password</label><br>
            <input type="password" name="c_password_new">
        </div>
        <div>
            <label for="c_passconf_new">Confirm new password</label><br>
            <input type="password" name="c_passconf_new">
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button type="submit">Renew password</button>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('pw-change.post') }}';
    </script>
    <script src="{{ URL::to('js/changepw.js') }}"></script>
@endsection