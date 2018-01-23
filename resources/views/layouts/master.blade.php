<!doctype html>
<html>
    <head>
        <meta name="csrf-token" content="{{ Session::token() }}">
        <title>@yield('title') | mscpldr</title>
    </head>
    <body>
        @yield('content')
        <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
        <script src="{{ URL::to('js/main.js') }}"></script>
        @yield('page-js')
    </body>
</html>
