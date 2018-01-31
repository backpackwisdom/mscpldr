@extends('layouts.master')

@section('title')
    {{ $album->c_albumnev }}
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')

    <div>
        <label>Favorited: {{ $album_fav_count }}</label>
        @if($album_is_fav == 0)
            <a href="{{ route('favorite.add', ['type_name' => 'album', 'type_id' => $album->id]) }}">Add</a>
        @else
            <a href="{{ route('favorite.remove', ['type_name' => 'album', 'type_id' => $album->id]) }}">Remove</a>
        @endif
    </div>

    <p>------------------------------------------------</p>

    <div>
        <img src="{{ route('album.cover', ['filename' => $album->c_boritonev]) }}" width="100" height="100">
    </div>
    <div>
        <label>{{ $album->c_albumnev }}</label>
    </div>
    <div>
        <label>{{ $album->c_eloado }}</label>
    </div>
    <div>
        <label>{{ $user->c_felhnev }}</label>
    </div>
    <div>
        <label>{{ $album->n_kiadev }}</label>
    </div>
    <div>
        <label>{{ $genre->c_mufajnev }}</label>
    </div>
    <div>
        <label>{{ $album->c_leiras }}</label>
    </div>

    <p>------------------------------------------------</p>

    <p>Tracklist</p>

    @foreach($tracks->all() as $track)
        <div>
            <p><a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}">{{ $loop->iteration }}. {{ $track->c_cim }}</a></p>
            <audio controls controlsList="nodownload">
                <source src="{{ route('track.content', ['filename' => $track->c_zenenev]) }}" type="audio/mpeg">
                <p>Your browser does not support audio content.</p>
            </audio>
        </div>
    @endforeach

    <p>------------------------------------------------</p>

    @if(Auth::user() == $user)
        <a href="{{ route('album-edit.get', ['album_id' => $album->id]) }}">Edit</a>
        <a onclick="confirmMessage('Do you really want to remove this album?')" href="{{ route('album.remove', ['album_id' => $album->id]) }}">Remove</a>
    @endif

    <p>------------------------------------------------</p>

    <button type="button" name="post-create">Create new post</button>

    @if(Auth::user())
        <form action="#" method="post" id="form-create-post" hidden>
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
    <script src="{{ URL::to('js/album.js') }}"></script>
@endsection