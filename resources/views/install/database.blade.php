@extends('layouts.install')

@section('title')
    Database
@stop

@section('side-menu')

    <a href="#" class="list-group-item disabled">
        <span class="fa fa-magic"></span>&nbsp;&nbsp;&nbsp;Welcome
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-server"></span>&nbsp;&nbsp;&nbsp;Requirements
    </a>
    <a href="{{ url('install/database') }}" class="list-group-item">
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

    {!! Form::open(['url'=>'install/database', 'method'=>'POST']) !!}

        @if( count($errors)>0 )
            <div class="row">
                <div class="col-md-12">

                    <div class="alert alert-warning">
                        <span class="fa fa-warning"></span>&nbsp;&nbsp;
                        @if( count($errors)==1 )
                            {{ $errors->all()[0] }}
                        @else
                            The following <b>validation errors</b> have been found:
                            <ul>
                                @foreach($errors->all() as $validation_error)

                                    <li>{{ $validation_error }}</li>

                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
            <br>
        @endif

        @if( session('error') )
            <div class="row">
                <div class="col-md-12">

                    <br>
                    <div class="alert alert-danger">
                        <span class="fa fa-plug"></span>&nbsp;&nbsp;
                        {{ session('error') }}
                    </div>

                </div>
            </div>
            <br>
        @endif

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Database host</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="database_host" value="{{ old('database_host') }}" class="form-control" placeholder="localhost">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Username</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="username">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Password</label>
            </div>
            <div class="col-md-8">
                <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="password">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Database name</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="database_name" value="{{ old('database_name') }}" class="form-control" placeholder="barmate">
            </div>
        </div>

        <button type="submit" class="btn btn-primary pull-right" style="margin-top:30px;">
            Configure application&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
        </button>

    </form>

@stop

@section('button-bar')

@stop