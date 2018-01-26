@extends('layouts.master')

@section('title')
    {{ $track->c_cim }}
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')

    <div>
        <label>{{ $track->c_cim }}</label>
    </div>
    <div>
        <label>{{ $track->c_eloado}}</label>
    </div>
    <div>
        <label>{{ $track->c_album }}</label>
    </div>
    <div>
        <label>{{ $user->c_felhnev }}</label>
    </div>
    <div>
        <label>{{ $track->n_kiadev }}</label>
    </div>
    <div>
        <label>{{ $track->c_leiras }}</label>
    </div>
    <div>
        <img src="{{ route('track.cover', ['filename' => $track->c_boritonev]) }}" width="100" height="100">
    </div>

    <audio controls controlsList="nodownload">
        <source src="{{ route('track.content', ['filename' => $track->c_zenenev]) }}" type="audio/mpeg">
        <p>Your browser does not support audio content.</p>
    </audio>

    <a href="{{ route('track-edit.get', ['track_id' => $track->id]) }}">Edit</a>
    <a onclick="confirmMessage('Do you really want to remove this track?')" href="{{ route('track-remove.get', ['track_id' => $track->id]) }}">Remove</a>
    @include('includes.footer')
@endsection