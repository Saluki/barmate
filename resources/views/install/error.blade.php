@extends('layouts.install')

@section('title')
    Configuration error
@stop

@section('side-menu')

    <a href="#" class="list-group-item disabled">
        <span class="fa fa-magic"></span>&nbsp;&nbsp;&nbsp;Welcome
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-server"></span>&nbsp;&nbsp;&nbsp;Requirements
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-database"></span>&nbsp;&nbsp;&nbsp;Database
    </a>
    <a href="{{ url('install/configuration') }}" class="list-group-item">
        <span class="fa fa-wrench"></span>&nbsp;&nbsp;&nbsp;Configuration
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;Account
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="alert alert-danger">
                <span class="fa fa-warning"></span>&nbsp;&nbsp;
                Barmate could not save the configuration for your application.
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="alert alert-info">
                Before continuing to the next step, please create a file named <b>.env</b>
                at the root of your application folder that contains the configuration text below.
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-body">

                        APP_ENV=production<br>
                        APP_DEBUG=false<br>
                        APP_URL={{ $configArray['app_url'] }}<br>
                        APP_KEY={{ $configArray['app_key'] }}<br>
                        APP_TIMEZONE={{ $configArray['app_timezone'] }}<br>
                        DB_DRIVER=mysql<br>
                        DB_HOST={{ $configArray['db_hostname'] }}<br>
                        DB_DATABASE={{ $configArray['db_name'] }}<br>
                        DB_USERNAME={{ $configArray['db_username'] }}<br>
                        DB_PASSWORD={{ $configArray['db_password'] }}<br>
                        MAIL_DRIVER=smtp<br>
                        MAIL_HOST=mailtrap.io<br>
                        MAIL_PORT=2525<br>
                        MAIL_USERNAME=null<br>
                        MAIL_PASSWORD=null<br>
                        CACHE_DRIVER=file<br>
                        SESSION_DRIVER=file<br>
                        QUEUE_DRIVER=sync

                </div>
            </div>

        </div>
    </div>

@stop

@section('button-bar')

    <a href="{{ url('install/check-config') }}" class="btn btn-primary pull-right">
        Create administrator account&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
    </a>

@stop