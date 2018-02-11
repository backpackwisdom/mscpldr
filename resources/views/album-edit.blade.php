@extends('layouts.master')

@section('title')
    Edit album
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/albumedit.css') }}">
@endsection

@section('content')
    <form action="{{ route('album-edit.post', ['album_id' => $album->id]) }}" method="post" enctype="multipart/form-data" id="form-edit-album">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card" id="editalbumtracksandcover">
                    <h5 class="card-header">Album tracks & cover</h5>
                    <div class="card-body">
                        <div id="select_albumszamok" class="form-group">
                            <label for="c_albumszamok">Choose your tracks to the album</label><br>
                            <input class="form-control" id="input-filter-list" type="text" placeholder="Filter tracks">

                            <ul id="tracks" class="list-group">
                                @foreach($tracks->all() as $track)
                                    <li class="list-group-item">
                                        {{ $track->c_eloado }} - {{ $track->c_cim }}
                                        <input type="checkbox" name="c_albumszamok[]" value="{{ $track->id }}" hidden @if(in_array($track->id, $albumtracks)) checked @endif>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <hr>

                        <div id="cover">
                            <label for="c_borito">Choose cover</label><br>
                            <input class="form-control" type="file" name="c_borito" accept="image/*">
                            <img class="img-thumbnail" src="#" width="150" height="150" hidden>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Album data</h5>
                    <div class="card-body" id="edit-album-data">
                        <div id="input_albumnev" class="form-group">
                            <label for="c_albumnev">Title</label><br>
                            <input class="form-control" type="text" name="c_albumnev" value="{{ $album->c_albumnev }}">
                        </div>

                        <div id="input_eloado" class="form-group">
                            <label for="c_eloado">Artist</label><br>
                            <input class="form-control" type="text" name="c_eloado" value="{{ $album->c_eloado }}">
                        </div>

                        <div id="input_kiadev" class="form-group">
                            <label for="n_kiadev">Release year</label><br>
                            <input class="form-control" type="number" name="n_kiadev" value="{{ $album->n_kiadev }}">
                        </div>

                        <div class="form-group">
                            <label for="n_mufajazon">Genre</label><br>
                            <select class="form-control" name="n_mufajazon">
                                @foreach($genres->all() as $genre)
                                    @if($genre->id == $album->n_mufajazon)
                                        <option value="{{ $genre->id }}" selected>{{ $genre->c_mufajnev }}</option>
                                    @endif
                                    <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="c_leiras">Description</label><br>
                            <textarea class="form-control" name="c_leiras">{{ $album->c_leiras }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button class="btn btn-outline-dark" type="submit">Save changes</button>
    </form>
@endsection

@section('page-js')
    <script>
        var coverName = '{{ $album->c_boritonev }}';
        var url = '{{ route('album-edit.post', ['album_id' => $album->id]) }}';
        var redirect_to = '{{ route('album.get', ['album_id' => $album->id, 'album_slug' => $album->c_albumlink]) }}';
    </script>
    <script src="{{ URL::to('js/albumedit.js') }}"></script>
@endsection