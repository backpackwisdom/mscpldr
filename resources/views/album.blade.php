@extends('layouts.master')

@section('title')
    {{ $album->c_albumnev }}
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/album.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <section id="album-data">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div>
                            <label id="album-title">{{ $album->c_albumnev }}</label>
                        </div>
                        <div>
                            <label>{{ $album->c_eloado }}</label>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div>
                            <label id="album-favs">{{ $album_fav_count }}</label>
                            @if($album_is_fav != null)
                                @if($album_is_fav == 0)
                                    <a href="{{ route('favorite.add', ['type_name' => 'album', 'type_id' => $album->id]) }}">
                                        <i class="far fa-star"></i>
                                    </a>
                                @else
                                    <a href="{{ route('favorite.remove', ['type_name' => 'album', 'type_id' => $album->id]) }}">
                                        <i class="far fa-star"></i>
                                    </a>
                                @endif
                            @else
                                <i class="fas fa-star"></i>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <label><strong>Uploaded by:</strong> {{ $user->c_felhnev }}</label>
                </div>
                <div>
                    <label><strong>Release year:</strong> {{ $album->n_kiadev }}</label>
                </div>

                <p><strong>Tracklist</strong></p>

                @foreach($tracks->all() as $track)
                    <div>
                        <p><a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}">{{ $loop->iteration }}. {{ $track->c_cim }}</a></p>
                        <audio controls controlsList="nodownload">
                            <source src="{{ route('track.content', ['filename' => $track->c_zenenev]) }}" type="audio/mpeg">
                            <p>Your browser does not support audio content.</p>
                        </audio>
                    </div>
                @endforeach

                @if(Auth::user() == $user)
                    <a class="btn btn-outline-primary" href="{{ route('album-edit.get', ['album_id' => $album->id]) }}">Edit</a>
                    <a class="btn btn-outline-danger" onclick="confirmMessage('Do you really want to remove this album?')" href="{{ route('album.remove', ['album_id' => $album->id]) }}">Remove</a>
                @endif

                <div>
                    <label><strong>Description</strong></label><br>
                    <label>{{ $album->c_leiras }}</label>
                </div>
            </section>
        </div>

        <div class="col-lg-6 col-md-6">
            <section id="album-desc-and-comments">
                <div>
                    <img id="album-cover" class="img-thumbnail" src="{{ route('album.cover', ['filename' => $album->c_boritonev]) }}" width="250" height="250">
                </div>

                @if(Auth::user())
                    <button class="btn btn-outline-primary" type="button" name="post-create">Create new post</button>
                @endif

                @if(Auth::user())
                    <form action="{{ route('post.create', ['post_type' => 'album', 'type_id' => $album->id]) }}" method="post" id="form-create-post" hidden>
                        <textarea name="c_szoveg" cols="50" rows="10"></textarea>
                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <button type="submit">Send</button>
                        <button type="button" name="post-cancel">Cancel</button>
                    </form>
                @endif

                <p><strong>Comments</strong></p>

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
            </section>
        </div>
    </div>

    <!-- Modal for enlarging cover -->
    <div id="album-cover-modal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>
@endsection

@section('page-js')
    <script src="{{ URL::to('js/album.js') }}"></script>
@endsection