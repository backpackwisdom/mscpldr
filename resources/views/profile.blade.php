@extends('layouts.master')

@section('title')
    {{ $user->c_felhnev }}
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')
    <p>{{ $user->c_felhnev }}</p>

    <div>
        <label>Username: </label>{{ $user->c_felhnev }}
    </div>
    <div>
        <label>Email: </label> {{ $user->c_email }}
    </div>
    <div>
        <label>Sign up date: </label> {{ $user->created_at }}
    </div>
    <div>
        <label>Online: </label> {{ $user->c_statusz }}
    </div>

    @if(Auth::user() != $user)
        @if($following == false)
            <form action="{{ route('follower.add', ['followed_id' => $user->id]) }}" method="post">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <button type="submit">Follow user</button>
            </form>
        @else
            <form action="{{ route('follower.remove', ['followed_id' => $user->id]) }}" method="post">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <button type="submit">Unfollow user</button>
            </form>
        @endif
    @endif

    @include('includes.footer')
@endsection