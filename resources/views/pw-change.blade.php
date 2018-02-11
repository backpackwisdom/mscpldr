@extends('layouts.master')

@section('title')
    Change password
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/changepw.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <form action="{{ route('pw-change.post') }}" method="post" id="form-pw-change">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="card">
                    <h5 class="card-header">Change password</h5>
                    <div class="card-body">
                        <p>To change your password, please type in the right data.</p>

                        <div id="input_oldpass" class="form-group">
                            <label for="c_password_old">Old password</label>
                            <input class="form-control" type="password" name="c_password_old">
                        </div>

                        <div id="input_newpass" class="form-group">
                            <label for="c_password_new">New password</label>
                            <input class="form-control" type="password" name="c_password_new">
                        </div>

                        <div id="input_newpassconf" class="form-group">
                            <label for="c_passconf_new">Confirm new password</label>
                            <input class="form-control" type="password" name="c_passconf_new">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <button class="btn btn-outline-dark" type="submit">Renew password</button>
            </div>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('pw-change.post') }}';
    </script>
    <script src="{{ URL::to('js/changepw.js') }}"></script>
@endsection