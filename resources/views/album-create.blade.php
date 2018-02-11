@extends('layouts.master')

@section('title')
    Create album
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/albumcreate.css') }}">
@endsection

@section('content')
    @if(count($tracks) > 0)
        <form action="{{ route('album-create.post') }}" method="post" enctype="multipart/form-data" id="form-create-album">
            <div class="row">
                <!-- choosing album tracks and cover -->
                <div class="col-lg-6 col-md-6">
                    <div class="card" id="create-album-tracksandcover">
                        <h5 class="card-header">Album tracks & cover</h5>
                        <div class="card-body">
                            <div id="select_albumszamok" class="form-group">
                                <label for="c_albumszamok">Choose your tracks to the album</label><br>
                                <input class="form-control" id="input-filter-list" type="text" placeholder="Filter tracks">

                                <ul id="tracks" class="list-group">
                                    @foreach($tracks->all() as $track)
                                        <li class="list-group-item">
                                            {{ $track->c_eloado }} - {{ $track->c_cim }}
                                            <input type="checkbox" name="c_albumszamok[]" value="{{ $track->id }}" hidden>
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

                <!-- album infos -->
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <h5 class="card-header">Album data</h5>
                        <div class="card-body" id="create-album-data">
                            <div id="input_albumnev" class="form-group">
                                <label for="c_albumnev">Title</label><br>
                                <input class="form-control" type="text" name="c_albumnev" value="{{ Request::old('c_albumnev') }}">
                            </div>

                            <div id="input_eloado" class="form-group">
                                <label for="c_eloado">Artist</label><br>
                                <input class="form-control" type="text" name="c_eloado" value="{{ Request::old('c_eloado') }}">
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
                                <textarea class="form-control" name="c_leiras">{{ Request::old('c_leiras') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="_token" value="{{ Session::token() }}">
            <button class="btn btn-outline-dark" type="submit">Create</button>
        </form>
    @else
        <p>You have to upload tracks to create an album.</p>
    @endif
@endsection

@section('page-js')
    <script>
        var url = '{{ route('album-create.post') }}';
        var redirect_to = '{{ route('dashboard') }}';
    </script>
    <script src="{{ URL::to('js/albumcreate.js') }}"></script>
@endsection