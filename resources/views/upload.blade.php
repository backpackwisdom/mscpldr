@extends('layouts.master')

@section('title')
    Upload
@endsection

@section('content')
    @include('includes.message')

    <p>Uploading music</p>

    <form action="{{ route('upload.post') }}" method="post" id="form-upload" enctype="multipart/form-data">
        <div id="track">
            <label for="c_szam">Choose your song to upload</label><br>
            <input type="file" name="c_szam" accept="audio/mpeg">
        </div>
        <div>
            <label for="c_cim">Title</label><br>
            <input type="text" name="c_cim" value="{{ Request::old('c_cim') }}">
        </div>
        <div>
            <label for="c_eloado">Artist</label><br>
            <input type="text" name="c_eloado" value="{{ Request::old('c_eloado') }}">
        </div>
        <div>
            <label for="c_album">Album name</label><br>
            <input type="text" name="c_album" value="{{ Request::old('c_album') }}">
        </div>
        <div id="cover">
            <label for="c_borito">Cover</label><br>
            <input type="file" name="c_borito" accept="image/*"><br>
            <img src="#" width="150" height="150" hidden>
        </div>
        <div>
            <label for="n_kiadev">Release year</label><br>
            <input type="number" name="n_kiadev" value="{{ Request::old('n_kiadev') }}">
        </div>
        <div>
            <label for="n_mufajazon">Genre</label><br>
            <select name="n_mufajazon">
                @foreach($genres->all() as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="c_leiras">Description</label><br>
            <textarea name="c_leiras" rows="5" cols="30">{{ Request::old('c_leiras') }}</textarea>
        </div>

        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button type="submit">Upload</button>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('upload.post') }}';
    </script>
    <script src="{{ URL::to('js/upload.js') }}"></script>
@endsection