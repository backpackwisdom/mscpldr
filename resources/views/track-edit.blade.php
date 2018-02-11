@extends('layouts.master')

@section('title')
    Edit track
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/trackedit.css') }}">
@endsection

@section('content')
    <form action="{{ route('track-edit.post', ['track_id' => $track->id]) }}" method="post" id="form-edit-track" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Updating cover</h5>
                    <div class="card-body">
                        <div id="cover" class="form-group">
                            <label for="c_borito">Cover</label><br>
                            <input class="form-control" type="file" name="c_borito" accept="image/*"><br>

                            @if($track->c_boritonev != 'nocover.jpg')
                                <img src="{{ route('track.cover', ['filename' => $track->c_boritonev]) }}" width="150" height="150">
                            @else
                                <img src="#" width="150" height="150" hidden>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                    <button class="btn btn-outline-dark" type="submit">Save changes</button>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Track data</h5>
                    <div class="card-body">
                        <div id="input_cim" class="form-group">
                            <label for="c_cim">Title</label><br>
                            <input class="form-control" type="text" name="c_cim" value="{{ $track->c_cim }}">
                        </div>

                        <div id="input_eloado" class="form-group">
                            <label for="c_eloado">Artist</label><br>
                            <input class="form-control" type="text" name="c_eloado" value="{{ $track->c_eloado }}">
                        </div>

                        <div id="input_album" class="form-group">
                            <label for="c_album">Album name</label><br>
                            <input class="form-control" type="text" name="c_album" value="{{ $track->c_album }}">
                        </div>

                        <div id="input_kiadev" class="form-group">
                            <label for="n_kiadev">Release year</label><br>
                            <input class="form-control" type="number" name="n_kiadev" value="{{ $track->n_kiadev }}">
                        </div>

                        <div class="form-group">
                            <label for="n_mufajazon">Genre</label><br>
                            <select class="form-control" name="n_mufajazon">
                                @foreach($genres->all() as $genre)
                                    @if($genre->id == $track->n_mufajazon)
                                        <option value="{{ $genre->id }}" selected>{{ $genre->c_mufajnev }}</option>
                                    @endif
                                    <option value="{{ $genre->id }}">{{ $genre->c_mufajnev }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="c_leiras">Description</label><br>
                            <textarea class="form-control" name="c_leiras" rows="5" cols="30">{{ $track->c_leiras }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('track-edit.post', ['track_id' => $track->id]) }}';
        var redirect_to = '{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}';
        var coverName = '{{ $track->c_boritonev }}';
    </script>
    <script src="{{ URL::to('js/trackedit.js') }}"></script>
@endsection