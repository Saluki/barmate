<!-- DEFAULT BARMATE APP TEMPLATE -->
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <title>
        @yield('title', 'Barmate')
    </title>
    
    <!-- CSS DEPENDENCIES & COMMON CSS -->
    @include('app.css')

    <!-- PAGE SPECIFIC CSS -->
    @yield('custom-css')

</head>
<body>
    
    <!-- DEFAULT BARMATE HEADER -->
    @include('app.header')
    
    <!-- PAGE CONTENT -->
    @yield('content')
    
    <!-- LEFT SLIDING MENU -->
    @include('app.menu')

    <!-- JS DEPENDENCIES & COMMON JS -->
    @include('app.js')
    
    <!-- PAGE SPECIFIC JS -->
    @yield('custom-js')
    
</body>
</html>