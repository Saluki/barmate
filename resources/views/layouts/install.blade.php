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

        <div class="container" id="install-container">

            <div class="row paper">

                <div class="paper-header">
                    <h2>
                        <i class="fa fa-download"></i>&nbsp;&nbsp;
                        Barmate POS Installation
                    </h2>
                </div>
                <div class="paper-body clearfix">

                    <div class="col-md-4">

                        <br>
                        <div class="list-group">

                            @yield('side-menu')

                        </div>

                    </div>

                    <div class="col-md-8">

                        <h2>@yield('title')</h2>

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

        </div>

    </body>
</html>