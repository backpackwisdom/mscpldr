@extends('layouts.master')

@section('title')
    Sign up
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/signup.css') }}">
@endsection

@section('content')
    <section id="signup">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
                <div class="card">
                    <h5 class="card-header">Sign up</h5>
                    <div class="card-body">
                        <p>After signing up, you'll be redirected to the home page to log in.</p>
                        <form action="{{ route('signup.post') }}" method="post" id="form-signup">
                            <div id="input_email" class="form-group">
                                <label for="Email">Email</label><br>
                                <input class="form-control" type="text" name="c_email" value="{{ Request::old('c_email') }}">
                            </div>
                            <div id="input_username" class="form-group">
                                <label for="username">Username</label><br>
                                <input class="form-control" type="text" name="c_username" value="{{ Request::old('c_username') }}">
                            </div>
                            <div id="input_password" class="form-group">
                                <label for="password">Password</label><br>
                                <input class="form-control" type="password" name="c_password">
                            </div>
                            <div id="input_passconf">
                                <label for="passconf">Password confirm</label><br>
                                <input class="form-control" type="password" name="c_passconf">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-outline-dark btn-block" type="submit">Submit</button>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('signup.post') }}';
        var base_url = '<?php echo url('/'); ?>';
    </script>
    <script src="{{ URL::to('js/signup.js') }}"></script>
@endsection