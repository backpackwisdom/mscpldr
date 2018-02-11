<!doctype html>
<html>
    <head>
        <meta name="csrf-token" content="{{ Session::token() }}">
        <title>@yield('title') | mscpldr</title>
        <link href="https://fonts.googleapis.com/css?family=Kalam" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap-grid.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/font-awesome/css/fontawesome-all.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/custombox.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('slick/slick.css') }}">
        <link rel="stylesheet" href="{{ URL::to('slick/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
        @yield('page-css')
    </head>
    <body>
        @include('includes.header')
        <div class="container">
            <div class="cm-aligning">
                @yield('content')
            </div>
        </div>
        @include('includes.footer')

        <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="{{ URL::to('js/bootstrap.js') }}"></script>
        <script src="{{ URL::to('js/custombox.min.js') }}"></script>
        <script src="{{ URL::to('js/custombox.legacy.min.js') }}"></script>
        <script src="{{ URL::to('slick/slick.js') }}"></script>
        <script src="{{ URL::to('js/main.js') }}"></script>
        @yield('page-js')
    </body>
</html>
