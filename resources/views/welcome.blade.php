@extends('layouts.master')

@section('title')
    Home
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/signin.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <section id="signin-cards">

        <p class="section-title">Logging in</p>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Sign in</h5>
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
                            <button type="submit" class="btn btn-outline-dark btn-block">Log me in!</button>
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

    <hr>

    <section id="signin-intro">
        <p class="section-title">Introduction</p>

        <p>Welcome to mscpldr, where you can easily share your favorite songs and albums.</p>
        @if(count($tracks) > 0)
            <div class="all-tracks">
                @foreach($tracks->all() as $track)
                    <div>
                        <img class="img-thumbnail" src="{{ route('track.cover', ['filename' => $track->c_boritonev]) }}" width="200" height="200"><br>
                        <label class="track-title">
                            <a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}">{{ $track->c_cim }}</a>
                        </label><br>
                        <label class="track-artist">{{ $track->c_eloado }}</label>
                    </div>
                @endforeach
            </div>
        @else
            <p>No tracks have been uploaded.</p>
        @endif

    </section>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('signin.post') }}';
        var redirect_to = '{{ route('dashboard') }}';
        var count_tracks = '{{ $count_tracks }}';
    </script>
    <script src="{{ URL::to('js/signin.js') }}"></script>
@endsection