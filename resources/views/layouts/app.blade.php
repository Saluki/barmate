<!-- DEFAULT BARMATE APP TEMPLATE -->
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <title>
        @yield('title', 'Barmate POS')
    </title>

    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- CSS DEPENDENCIES & COMMON CSS -->
    @include('includes.css')

    <!-- PAGE SPECIFIC CSS -->
    @yield('custom-css')

</head>
<body>
    
    <!-- DEFAULT BARMATE HEADER -->
    @include('includes.header')
    
    <!-- PAGE CONTENT -->
    @yield('content')
    
    <!-- LEFT SLIDING MENU -->
    @include('includes.menu')

    <!-- JS DEPENDENCIES & COMMON JS -->
    @include('includes.js')
    
    <!-- PAGE SPECIFIC JS -->
    @yield('custom-js')
    
</body>
</html>