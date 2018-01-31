@extends('layouts.master')

@section('title')
    Home
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/signin.css') }}">
@endsection

@section('content')
    <section id="signin-cards">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Sign up</h5>
                    <div class="card-body">
                        <h4>Log in to start exploring!</h4>
                        <form action="{{ route('signin.post') }}" method="post" id="form-signin">
                            <div id="input_username" class="form-group">
                                <label for="username">Username</label><br>
                                <input class="form-control" type="text" name="c_username" value="{{ Request::old('c_username') }}">
                            </div>
                            <div id="input_password" class="form-group">
                                <label for="password">Password</label><br>
                                <input class="form-control" type="password" name="c_password">
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Log me in!</button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Password reminder</h5>
                    <div class="card-body">
                        <p>Forgot your password? Enter your email to get a reminder.</p>
                        <form action="#" method="post" id="form-pw-forgotten">
                            <div class="row">
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" name="c_email" value="{{ Request::old('c_email') }}">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-danger">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="signin-intro">
        <div class="row">
            <div class="col-lg-12">
                Introduction
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('signin.post') }}';
    </script>
    <script src="{{ URL::to('js/signin.js') }}"></script>
@endsection