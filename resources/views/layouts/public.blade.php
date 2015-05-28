<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Barmate</title> 
        
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    </head>
    <body>
        
        <header>
            @include('public.header')
        </header>
        
        <div class="container" style="margin-top:70px;">
            @yield('content', '<i>Nothing to display</i>')
        </div>
        
    </body>
</html>