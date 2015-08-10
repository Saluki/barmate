@extends('layouts.install')

@section('title')
    Database
@stop

@section('side-menu')

    <a href="{{ url('install') }}" class="list-group-item">
        <span class="fa fa-magic"></span>&nbsp;&nbsp;&nbsp;Welcome
    </a>
    <a href="{{ url('install/requirements') }}" class="list-group-item">
        <span class="fa fa-server"></span>&nbsp;&nbsp;&nbsp;Requirements
    </a>
    <a href="{{ url('install/database') }}" class="list-group-item">
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

    {!! Form::open(['url'=>'installer/database', 'method'=>'POST']) !!}

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Database host</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="http://localhost">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Database name</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="barmate">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Username</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="username">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Password</label>
            </div>
            <div class="col-md-8">
                <input type="password" class="form-control" placeholder="password">
            </div>
        </div>

        <!--<div class="row">
            <div class="col-md-12">

                <br>
                <div class="alert alert-danger">
                    <span class="fa fa-warning"></span>&nbsp;&nbsp;
                    Barmate can't connect to your database. Please check your settings again.
                </div>

            </div>
        </div>-->

    </form>

@stop

@section('button-bar')

    <a href="{{ url('install/configuration') }}" class="btn btn-primary pull-right">
        Configure application&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
    </a>

@stop