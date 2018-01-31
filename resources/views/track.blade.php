@extends('layouts.master')

@section('title')
    {{ $track->c_cim }}
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')

    <div>
        <label>Favorited: {{ $track_fav_count }}</label>
        @if($track_is_fav == 0)
            <a href="{{ route('favorite.add', ['type_name' => 'track', 'type_id' => $track->id]) }}">Add</a>
        @else
            <a href="{{ route('favorite.remove', ['type_name' => 'track', 'type_id' => $track->id]) }}">Remove</a>
        @endif
    </div>

    <p>------------------------------------------------</p>

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

    <p>------------------------------------------------</p>

    @if(Auth::user() == $user)
        <a href="{{ route('track-edit.get', ['track_id' => $track->id]) }}">Edit</a>
        <a onclick="confirmMessage('Do you really want to remove this track?')" href="{{ route('track-remove.get', ['track_id' => $track->id]) }}">Remove</a>
    @endif

    <p>------------------------------------------------</p>

    <button type="button" name="post-create">Create new post</button>

    @if(Auth::user())
        <form action="{{ route('post.create', ['post_type' => 'track', 'type_id' => $track->id]) }}" method="post" id="form-create-post" hidden>
            <textarea name="c_szoveg" cols="50" rows="10"></textarea>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit">Send</button>
            <button type="button" name="post-cancel">Cancel</button>
        </form>
    @endif

    <p>------------------------------------------------</p>

    <p>Comments</p>

    @if(count($posts) > 0)
        @foreach($posts as $post)
            <article data-postid="{{ $post->id }}">
                <label>{{ $post->c_felhnev }} - {{ $post->created_at }}</label>

                @if(Auth::user())
                    <button type="button" name="post-reply">Reply</button>

                    @if($user == Auth::user())
                        <a name="post-delete" href="{{ route('post.remove', ['post_id' => $post->id]) }}">Remove</a><br>
                    @else
                        <br>
                    @endif

                    @if(is_null($post->d_jelol_datum) and $user != Auth::user())
                        <a href="{{ route('favorite.add', ['type_name' => 'post', 'type_id' => $post->id]) }}">Upvote</a>
                    @endif
                @endif

                <p>{{ $post->c_szoveg }}</p>
            </article>
        @endforeach
    @else
        <p>There are no comments.</p>
    @endif

    @include('includes.footer')
@endsection

@section('page-js')
    <script>
        var url_createpost = '{{ route('post.create', ['post_type' => 'track', 'type_id' => $track->id]) }}';
    </script>
    <script src="{{ URL::to('js/track.js') }}"></script>
@endsection