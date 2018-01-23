<header>
    <nav>
        <ul>
            @if(Auth::user()) <!-- if user is logged in -->
                @if(!Route::is('dashboard'))
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @endif

                @if(!Route::is('upload.get'))
                    <li><a href="{{ route('upload.get') }}">Upload</a></li>
                @endif

                <li>{{ Auth::user()->c_felhnev }}
                    <ul>
                        <li><a href="{{ route('settings.get') }}">Settings</a></li>
                        <li><a href="{{ route('pw-change.get') }}">Change password</a></li>
                    </ul>
                </li>

                @if(!Route::is('followed.get'))
                    <li><a href="{{ route('followed.get') }}">Subscriptions</a></li>
                @endif

                <li><a href="{{ route('logout') }}">Log out</a></li>
            @else
                @if(!Route::is('signup.get'))
                    <li><a href="{{ route('signup.get') }}">Sign up</a></li>
                @endif

                @if(!Route::is('home'))
                    <li><a href="{{ route('home') }}">Home</a></li>
                @endif
            @endif
        </ul>
    </nav>
</header>