@extends('layouts.master')

@section('title')
    Edit track
@endsection

@section('content')
    @include('includes.header')
    @include('includes.message')

    <p>Editing your track</p>

    <form action="{{ route('track-edit.post', ['track_id' => $track->id]) }}" method="post" id="form-edit-track" enctype="multipart/form-data">
        <div>
            <label for="c_cim">Title</label><br>
            <input type="text" name="c_cim" value="{{ $track->c_cim }}">
        </div>
        <div>
            <label for="c_eloado">Artist</label><br>
            <input type="text" name="c_eloado" value="{{ $track->c_eloado }}">
        </div>
        <div>
            <label for="c_album">Album name</label><br>
            <input type="text" name="c_album" value="{{ $track->c_album }}">
        </div>
        <div id="cover">
            <label for="c_borito">Cover</label><br>
            <input type="file" name="c_borito" accept="image/*"><br>

            @if($track->c_boritonev != 'nocover.jpg')
                <img src="{{ route('track.cover', ['filename' => $track->c_boritonev]) }}" width="150" height="150">
            @else
                <img src="#" width="100" height="100" hidden>
            @endif

        </div>
        <div>
            <label for="n_kiadev">Release year</label><br>
            <input type="number" name="n_kiadev" value="{{ $track->n_kiadev }}">
        </div>
        <div>
            <label for="n_mufajazon">Genre</label><br>
            <select name="n_mufajazon">
                @foreach($genres->all() as $genre)
                    @if($genre->id == $track->n_mufajazon)
                        <option value="{{ $genre->id }}" selected>{{ $genre->c_mufajnev }}</option>
                    @endif
                    <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="c_leiras">Description</label><br>
            <textarea name="c_leiras" rows="5" cols="30">{{ $track->c_leiras }}</textarea>
        </div>

        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button type="submit">Save changes</button>
    </form>

    @include('includes.footer')
@endsection

@section('page-js')
    <script>
        var url = '{{ route('track-edit.post', ['track_id' => $track->id]) }}';
        var redirect_to = '{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}';
        var coverName = '{{ $track->c_boritonev }}';
    </script>
    <script src="{{ URL::to('js/trackedit.js') }}"></script>
@endsection