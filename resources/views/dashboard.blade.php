@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/dashboard.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <p class="section-title">Latest activities</p>

    @if(count($tracks) > 0)
        <div class="new-tracks">
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

    <hr>

    <p class="section-title">Subscriptions' activities</p>

    <hr>

    <p class="section-title">Recommended</p>

    <hr>

    <p class="section-title">Albums</p>

    @if(count($albums) > 0)
        <div class="new-albums">
            @foreach($albums->all() as $album)
                <div>
                    <img class="img-thumbnail" src="{{ route('album.cover', ['filename' => $album->c_boritonev]) }}" width="200" height="200">
                    <label class="album-title">
                        <a href="{{ route('album.get', ['album_id' => $album->id, 'album_slug' => $album->c_albumlink]) }}">{{ $album->c_albumnev }}</a>
                    </label><br>
                    <label class="album-artist">{{ $album->c_eloado }}</label>
                </div>
            @endforeach
        </div>
    @else
        <p>No albums have been uploaded.</p>
    @endif

    <hr>

    <p class="section-title">Latest users</p>

    <div class="new-users">
        @foreach($users->all() as $user)
            <div>
                <img class="img-thumbnail" src="{{ route('avatar.get', ['user_id' => $user->id, 'filename' => $user->c_avatarlink]) }}" width="150" height="150"><br>
                <label class="user-name">
                    <a href="{{ route('user.get', ['user_id' => $user->id]) }}">{{ $user->c_felhnev }}</a>
                </label>
            </div>
        @endforeach
    </div>

@endsection

@section('page-js')
    <script>
        var count_tracks = '{{ $count_tracks }}';
        var count_albums = '{{ $count_albums }}';
        var count_users = '{{ $count_users }}';
    </script>
    <script src="{{ URL::to('js/dashboard.js') }}"></script>
@endsection