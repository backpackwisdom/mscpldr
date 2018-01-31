
    <nav class="navbar fixed-top navbar-expand-lg">
        <a class="navbar-brand" href="#">mscpldr</a>
        <button class="navbar-toggler custom-toggler btn btn-outline-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @if(Auth::user()) <!-- if user is logged in -->
                    @if(!Route::is('dashboard'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif

                    @if(!Route::is('upload.get'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('upload.get') }}">Upload</a>
                        </li>
                    @endif

                    @if(!Route::is('album-create.get'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('album-create.get') }}">Create album</a>
                        </li>
                    @endif

                    <li class="nav-item dropdown ml-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ route('avatar.get', ['user_id' => Auth::user()->id, 'filename' => Auth::user()->c_avatarlink]) }}" width="20" height="20" class="rounded">
                            {{ Auth::user()->c_felhnev }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('settings.get') }}">Profile settings</a>
                            <a class="dropdown-item" href="{{ route('pw-change.get') }}">Change password</a>
                        </div>
                    </li>

                    @if(!Route::is('followed.get'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('followed.get') }}">Subscriptions</a>
                        </li>
                    @endif

                    <li class="nav-item ml-3">
                        <a class="nav-link" href="{{ route('logout') }}">Log out</a>
                    </li>
                @else
                    @if(!Route::is('signup.get'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('signup.get') }}">Sign up</a>
                        </li>
                    @endif

                    @if(!Route::is('home'))
                        <li class="nav-item ml-3">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
