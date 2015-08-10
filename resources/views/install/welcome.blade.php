@extends('layouts.install')

@section('title')
    Welcome
@stop

@section('side-menu')

    <a href="{{ url('install') }}" class="list-group-item">
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
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    This wizard will help you install the Barmate POS application on your server.

@stop

@section('button-bar')

    <a href="{{ url('install/requirements') }}" class="btn btn-primary pull-right">
        Requirements&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
    </a>

@stop