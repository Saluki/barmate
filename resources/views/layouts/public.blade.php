<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Barmate POS</title>

        <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
        
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/fontawesome/css/font-awesome.min.css') }}">

    </head>
    <body>
        
        <div class="container" style="margin-top:180px;">
            @yield('content')
        </div>
        
    </body>
</html>