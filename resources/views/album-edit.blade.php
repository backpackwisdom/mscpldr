@extends('layouts.master')

@section('title')
    Edit album
@endsection

@section('content')
    @include('includes.message')

    <p>Editing album</p>

    <form action="{{ route('album-edit.post', ['album_id' => $album->id]) }}" method="post" enctype="multipart/form-data" id="form-edit-album">
        <div>
            <div>
                <label for="c_albumszamok">Choose your tracks to the album</label>
                <ul>
                    @foreach($tracks->all() as $track)
                        <li>
                            <input type="checkbox" name="c_albumszamok[]" value="{{ $track->id }}" @if(in_array($track->id, $albumtracks)) checked @endif>
                            <a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}" target="_blank">
                                {{ $track->c_eloado }} - {{ $track->c_cim }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <label for="c_albumnev">Title</label><br>
                <input type="text" name="c_albumnev" value="{{ $album->c_albumnev }}">
            </div>

            <div>
                <label for="c_eloado">Artist</label><br>
                <input type="text" name="c_eloado" value="{{ $album->c_eloado }}">
            </div>

            <div id="cover">
                <label for="c_borito">Cover</label><br>
                <input type="file" name="c_borito" accept="image/*"><br>

                @if($album->c_boritonev != 'nocover.jpg')
                    <img src="{{ route('album.cover', ['filename' => $album->c_boritonev]) }}" width="150" height="150">
                @else
                    <img src="#" width="100" height="100" hidden>
                @endif
            </div>

            <div>
                <label for="n_kiadev">Release year</label><br>
                <input type="number" name="n_kiadev" value="{{ $album->n_kiadev }}">
            </div>

            <div>
                <label for="n_mufajazon">Genre</label><br>
                <select name="n_mufajazon">
                    @foreach($genres->all() as $genre)
                        @if($genre->id == $album->n_mufajazon)
                            <option value="{{ $genre->id }}" selected>{{ $genre->c_mufajnev }}</option>
                        @endif
                        <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="c_leiras">Description</label><br>
                <textarea name="c_leiras" rows="5" cols="30">{{ $album->c_leiras }}</textarea>
            </div>

            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button type="submit">Save changes</button>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('album-edit.post', ['album_id' => $album->id]) }}';
        var redirect_to = '{{ route('album.get', ['album_id' => $album->id, 'album_slug' => $album->c_albumlink]) }}';
        var coverName = '{{ $album->c_boritonev }}';
    </script>
    <script src="{{ URL::to('js/albumedit.js') }}"></script>
@endsection