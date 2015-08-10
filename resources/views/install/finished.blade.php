@extends('layouts.install')

@section('title')
    Finished
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
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-wrench"></span>&nbsp;&nbsp;&nbsp;Configuration
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;Account
    </a>
    <a href="{{ url('install/finished') }}" class="list-group-item">
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    <b>Congratulations!</b> The Barmate POS application is installed on your server and ready to use. You can now login into the application with your administrator account.

    <div id="finished-btn">
        <a href="{{ url(' ') }}" class="btn btn-primary">Login into Barmate POS</a>
    </div>

@stop

@section('button-bar')

@stop