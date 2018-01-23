@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    @include('includes.header')
    Welcome to the dashboard, {{ Auth::user()->c_felhnev }}!

    <p>Latest users</p>
    @if(count($users) > 0)
        <ul>
            @foreach($users->all() as $user)
                <li><a href="{{ route('user.get', ['user_id' => $user->id]) }}">{{ $user->c_felhnev }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection