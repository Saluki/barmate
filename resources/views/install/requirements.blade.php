@extends('layouts.install')

@section('title')
    Requirements
@stop

@section('side-menu')

    <a href="#" class="list-group-item disabled">
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
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;Account
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    @unless( $accepted )

        <div class="alert alert-warning">
            <span class="fa fa-warning"></span>&nbsp;
            <b>Watch out!</b> Barmate can only be installed if all requirements are satisfied.
        </div>

    @else

        <div class="alert alert-success">
            <span class="fa fa-check"></span>&nbsp;
            <b>Well done!</b> All requirement are satisfied. You can continue the installation process.
        </div>

    @endunless

    <ul class="list-group">

        <!-- PHP VERSION -->
        @if( $requirements['PHP_VERSION'] )
            <li class="list-group-item">
                <b>PHP Version</b><br>
                The current PHP version is higher or equal to 5.5.9
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>PHP Version</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The PHP version must be higher or equal to 5.5.9
            </li>
        @endif

        <!-- OPENSSL EXTENSION -->
        @if( $requirements['OPENSSL_EXTENSION'] )
            <li class="list-group-item">
                <b>OpenSSL extension</b><br>
                The PHP OpenSSL extension is installed
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>OpenSSL extension</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The PHP OpenSSL extension has not been found
            </li>
        @endif

        <!-- PDO EXTENSION -->
        @if( $requirements['PDO_EXTENSION'] )
            <li class="list-group-item">
                <b>PDO extension</b><br>
                The PHP PDO extension is installed
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>PDO extension</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The PHP PDO extension has not been found
            </li>
        @endif

        <!-- MBSTRING EXTENSION -->
        @if( $requirements['MBSTRING_EXTENSION'] )
            <li class="list-group-item">
                <b>Mbstring extension</b><br>
                The PHP Mbstring extension is installed
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>Mbstring extension</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The PHP Mbstring extension has not been found
            </li>
        @endif

        <!-- TOKENIZER EXTENSION -->
        @if( $requirements['TOKENIZER_EXTENSION'] )
            <li class="list-group-item">
                <b>Tokenizer extension</b><br>
                The PHP Tokenizer extension is installed
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>Tokenizer extension</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The PHP Tokenizer extension has not been found
            </li>
        @endif

        <!-- WRITE ACCESS -->
        @if( $requirements['WRITE_ACCESS'] )
            <li class="list-group-item">
                <b>Write access to storage folder</b><br>
                The application has write access to the storage folder
            </li>
        @else
            <li class="list-group-item list-group-item-danger">
                <b>Write access to storage folder</b>
                &nbsp;<span class="fa fa-warning"></span><br>
                The "storage" folder must be writable for the application
            </li>
        @endif

    </ul>

@stop

@section('button-bar')

    @if( $accepted  )
        <a href="{{ url('install/database') }}" class="btn btn-primary pull-right">
            Configure database&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
        </a>
    @endif

@stop