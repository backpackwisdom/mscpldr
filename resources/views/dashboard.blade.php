@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')
    Welcome to the dashboard, {{ Auth::user()->c_felhnev }}!

    <p>Latest tracks</p>
    @if(count($tracks) > 0)
        <ul>
            @foreach($tracks->all() as $track)
                <li><a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}">{{ $track->c_eloado }} - {{ $track->c_cim }}</a></li>
            @endforeach
        </ul>
    @endif

    <p>Latest albums</p>

    <p>Latest users</p>
    @if(count($users) > 0)
        <ul>
            @foreach($users->all() as $user)
                <li><a href="{{ route('user.get', ['user_id' => $user->id]) }}">{{ $user->c_felhnev }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection