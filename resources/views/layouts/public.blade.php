<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            @yield('title','Barmate POS')
        </title>

        <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
        
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/fontawesome/css/font-awesome.min.css') }}">

        @yield('custom-css', '')

    </head>
    <body>
        
        <div class="container">
            @yield('content')
        </div>

        <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>

        @yield('custom-js', '')
        
    </body>
</html>