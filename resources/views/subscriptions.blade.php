@extends('layouts.master')

@section('title')
    Subscriptions
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')

    <p>Followed</p>
    @if(count($followed) > 0)
        @foreach($followed->all() as $f)
            <div>
                <img src="{{ route('avatar.get', ['user_id' => $f->id, 'filename' => $f->c_avatarlink]) }}" width="100" height="100"><br>
                <label>{{ $f->c_felhnev }}</label>
            </div>
        @endforeach
    @endif

    <p>---------------------------------------</p>

    <p>Followers</p>
    @if(count($followers) > 0)
        @foreach($followers->all() as $f)
            <div>
                <img src="{{ route('avatar.get', ['user_id' => $f->id, 'filename' => $f->c_avatarlink]) }}" width="100" height="100"><br>
                <label>{{ $f->c_felhnev }}</label>
            </div>
        @endforeach
    @endif

    @include('includes.footer')
@endsection