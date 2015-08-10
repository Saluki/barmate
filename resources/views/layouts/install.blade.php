<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            @yield('title') - Barmate POS
        </title>

        <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">

        <!-- CSS Dependencies -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/fontawesome/css/font-awesome.min.css') }}">

        <!-- CSS Custom -->
        <link rel="stylesheet" href="{{ asset('build/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('build/css/install.css') }}">

    </head>
    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <div class="wizard-header">
                        <span class="logo-title">Barmate&nbsp;&nbsp;</span>
                        <span class="logo-subtitle">Installation Wizard</span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4">

                    <br>
                    <div class="list-group">

                        @yield('side-menu')

                    </div>

                </div>

                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-8">

                            <h2>@yield('title')</h2>

                        </div>
                        <div class="col-md-4">

                            <a href="javascript:window.location.href=window.location.href" class="btn btn-default pull-right" style="margin-top: 20px;">
                                <span class="fa fa-refresh"></span>&nbsp;&nbsp;Refresh page
                            </a>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" id="wizard-content">

                            @yield('content')

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            @yield('button-bar')

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>