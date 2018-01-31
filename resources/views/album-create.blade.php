@extends('layouts.master')

@section('title')
    Create album
@endsection

@section('content')
    @include('includes.message')

    <p>Creating album</p>

    <form action="{{ route('album-create.post') }}" method="post" enctype="multipart/form-data" id="form-create-album">
        <div>

            @if(count($tracks) > 0)
                <div>
                    <label for="c_albumszamok">Choose your tracks to the album</label>
                    <ul>
                        @foreach($tracks->all() as $track)
                            <li>
                                <input type="checkbox" name="c_albumszamok[]" value="{{ $track->id }}">
                                <a href="{{ route('track.get', ['track_id' => $track->id, 'track_slug' => $track->c_zenelink]) }}" target="_blank">
                                    {{ $track->c_eloado }} - {{ $track->c_cim }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <label for="c_albumnev">Title</label><br>
                    <input type="text" name="c_albumnev" value="{{ Request::old('c_albumnev') }}">
                </div>

                <div>
                    <label for="c_eloado">Artist</label><br>
                    <input type="text" name="c_eloado" value="{{ Request::old('c_eloado') }}">
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
                <button type="submit">Create</button>
            @else
                <p>You have to upload tracks to create an album.</p>
            @endif

        </div>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('album-create.post') }}';
    </script>
    <script src="{{ URL::to('js/albumcreate.js') }}"></script>
@endsection