@extends('layouts.install')

@section('title')
    Requirements
@stop

@section('side-menu')

    <a href="{{ url('install') }}" class="list-group-item">
        <span class="fa fa-magic"></span>&nbsp;&nbsp;&nbsp;Welcome
    </a>
    <a href="{{ url('install/requirements') }}" class="list-group-item">
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

    <ul class="list-group">
        <li class="list-group-item list-group-item-success">
            <b>PHP Version</b><br>
            The current PHP version is higher than 5.5.9
        </li>
        <li class="list-group-item list-group-item-success">
            <b>OpenSSL extension</b><br>
            The PHP OpenSSL extension is installed
        </li>
        <li class="list-group-item list-group-item-success">
            <b>PDO extension</b><br>
            The PHP PDO extension is installed
        </li>
        <li class="list-group-item list-group-item-success">
            <b>Mbstring extension</b><br>
            The PHP Mbstring extension is installed
        </li>
        <li class="list-group-item list-group-item-success">
            <b>Tokenizer extension</b><br>
            The PHP Tokenizer extension is installed
        </li>
        <li class="list-group-item list-group-item-success">
            <b>Write access to storage</b><br>
            The application has write access on the storage folder
        </li>
    </ul>

@stop

@section('button-bar')

    <a href="{{ url('install/database') }}" class="btn btn-primary pull-right">
        Configure database&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
    </a>

@stop