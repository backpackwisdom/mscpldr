@extends('layouts.master')

@section('title')
    Upload
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/upload.css') }}">
@endsection

@section('content')
    <form action="{{ route('upload.post') }}" method="post" id="form-upload" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Uploading track and cover</h5>
                    <div class="card-body">
                        <div id="track" class="form-group">
                            <label for="c_szam">Choose your song to upload</label><br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input class="form-control" type="file" name="c_szam" accept="audio/mpeg">
                                </div>
                            </div>
                        </div>

                        <div id="cover" class="form-group">
                            <label for="c_borito">Cover</label><br>
                            <input class="form-control" type="file" name="c_borito" accept="image/*"><br>
                            <img src="#" width="150" height="150" hidden>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <button class="btn btn-outline-dark" type="submit" disabled>Upload</button>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Track data</h5>
                    <div class="card-body">
                        <div id="input_cim" class="form-group">
                            <label for="c_cim">Title</label><br>
                            <input class="form-control" type="text" name="c_cim" value="{{ Request::old('c_cim') }}">
                        </div>

                        <div id="input_eloado" class="form-group">
                            <label for="c_eloado">Artist</label><br>
                            <input class="form-control" type="text" name="c_eloado" value="{{ Request::old('c_eloado') }}">
                        </div>

                        <div id="input_album" class="form-group">
                            <label for="c_album">Album name</label><br>
                            <input class="form-control" type="text" name="c_album" value="{{ Request::old('c_album') }}">
                        </div>

                        <div id="input_kiadev" class="form-group">
                            <label for="n_kiadev">Release year</label><br>
                            <input class="form-control" type="number" name="n_kiadev" value="{{ Request::old('n_kiadev') }}">
                        </div>

                        <div class="form-group">
                            <label for="n_mufajazon">Genre</label><br>
                            <select class="form-control" name="n_mufajazon">
                                @foreach($genres->all() as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="c_leiras">Description</label><br>
                            <textarea class="form-control" name="c_leiras" rows="5" cols="30">{{ Request::old('c_leiras') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('upload.post') }}';
        var redirect_to = '{{ route('dashboard') }}';
    </script>
    <script src="{{ URL::to('js/upload.js') }}"></script>
@endsection