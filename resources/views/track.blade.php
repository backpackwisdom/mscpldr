@extends('layouts.master')

@section('title')
    {{ $track->c_cim }}
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/track.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <section id="track-data">
                <div class="row">
                    <!-- track title & artist name -->
                    <div class="col-lg-9 col-md-9">
                        <div>
                            <label id="track-title"><strong>{{ $track->c_cim }}</strong></label>
                        </div>
                        <div>
                            <label id="track-artist">{{ $track->c_eloado}}</label>
                        </div>
                    </div>

                    <!-- favorites -->
                    <div class="col-lg-3 col-md-3">
                        <div>
                            <label id="track-favs">{{ $track_fav_count }}</label>
                            @if($track_is_fav != null)
                                @if($track_is_fav == 0)
                                    <a href="{{ route('favorite.add', ['type_name' => 'track', 'type_id' => $track->id]) }}">
                                        <i class="far fa-star"></i>
                                    </a>
                                @else
                                    <a href="{{ route('favorite.remove', ['type_name' => 'track', 'type_id' => $track->id]) }}">
                                        <i class="far fa-star"></i>
                                    </a>
                                @endif
                            @else
                                <i class="fas fa-star"></i>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <!-- playable audio file -->
                <audio controls controlsList="nodownload">
                    <source src="{{ route('track.content', ['filename' => $track->c_zenenev]) }}" type="audio/mpeg">
                    <p>Your browser does not support audio content.</p>
                </audio>

                <hr>

                <!-- album data -->
                <div>
                    <label><strong>Album:</strong> {{ $track->c_album }}</label>
                </div>

                <hr>

                <div>
                    <label>
                        <strong>Uploaded by:</strong>
                        <a href="{{ route('user.get', ['user_id' => $user->id]) }}">{{ $user->c_felhnev }}</a>
                    </label>
                </div>

                <hr>

                <div>
                    <label><strong>Release year:</strong> {{ $track->n_kiadev }}</label>
                </div>

                <hr>

                <!-- edit/remove button for the uploader -->
                @if(Auth::user() == $user)
                    <a class="btn btn-outline-primary" href="{{ route('track-edit.get', ['track_id' => $track->id]) }}">Edit</a>
                    <a class="btn btn-outline-danger" onclick="confirmMessage('Do you really want to remove this track?')" href="{{ route('track-remove.get', ['track_id' => $track->id]) }}">Remove</a>

                    <hr>
                @endif

                <!-- description -->
                <div>
                    <label><strong>Description</strong></label><br>
                    <label>{{ $track->c_leiras }}</label>
                </div>
            </section>
        </div>

        <div class="col-lg-6 col-md-6">
            <section id="track-desc-and-comments">
                <!-- track cover -->
                <div>
                    <img id="track-cover" class="img-thumbnail" src="{{ route('track.cover', ['filename' => $track->c_boritonev]) }}" width="250" height="250">
                </div>

                <hr>

                <!-- create post button & field -->
                @if(Auth::user())
                    <button class="btn btn-outline-primary" type="button" name="post-create">Create new post</button>

                    <form action="{{ route('post.create', ['post_type' => 'track', 'type_id' => $track->id]) }}" method="post" id="form-create-post" hidden>
                        <div id="textarea_body" class="form-group">
                            <textarea class="form-control" name="c_szoveg" cols="50" rows="10"></textarea>
                        </div>

                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                        <button class="btn btn-outline-primary" type="submit">Send</button>
                        <button class="btn btn-outline-danger" type="button" name="post-cancel">Cancel</button>
                    </form>

                    <hr>
                @endif

                <!-- comments -->
                <p><strong>Comments</strong></p>

                @if(count($posts) > 0)
                    <div id="track-comments">
                        @foreach($posts as $post)
                            <div class="comment-box" data-postid="{{ $post->id }}">
                                <!-- place avatar here -->
                                <div class="comment-user"><strong>{{ $post->c_felhnev }}</strong></div>
                                <p class="comment-body">{{ $post->c_szoveg }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>There are no comments.</p>
                @endif

            </section>
        </div>
    </div>

    <!-- Modal for enlarging cover -->
    <div id="track-cover-modal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>
@endsection

@section('page-js')
    <script>
        var url_createpost = '{{ route('post.create', ['post_type' => 'track', 'type_id' => $track->id]) }}';
    </script>
    <script src="{{ URL::to('js/track.js') }}"></script>
@endsection