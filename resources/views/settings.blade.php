@extends('layouts.master')

@section('title')
    Profile settings
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ URL::to('css/settings.css') }}">
@endsection

@section('content')
    @include('includes.message')

    <form action="{{ route('settings.post') }}" method="post" id="form-account" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">User avatar</h5>
                    <div class="row">
                        <div class="col-lg-3">
                            <img class="img-thumbnail" src="{{ route('avatar.get', ['user_id' => $user->id, 'filename' => $user->c_avatarlink]) }}" width="100" height="100">
                        </div>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="c_avatarlink" accept="image/*">
                        </div>
                    </div>

                    <button class="btn btn-outline-danger" type="submit" name="submitbutton" value="remove-avatar" {{ ($user->c_avatarlink) == 'noavatar.jpg' ? "style=display:none;" : "" }}>Remove avatar</button>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">User data</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="c_username">Username</label><br>
                            <input class="form-control" type="text" name="c_username" value="{{ $user->c_felhnev }}" disabled="disabled">
                        </div>

                        <div id="input_email" class="form-group">
                            <label for="c_email">Email</label><br>
                            <input class="form-control" type="text" name="c_email" value="{{ $user->c_email }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="{{ Session::token() }}">
        <button class="btn btn-outline-dark" type="submit" name="submitbutton" value="submit">Save changes</button>
    </form>
@endsection

@section('page-js')
    <script>
        var url = '{{ route('settings.post') }}';
    </script>
    <script src="{{ URL::to('js/changeacc.js') }}"></script>
@endsection