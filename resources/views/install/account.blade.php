@extends('layouts.install')

@section('title')
    Account
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
    <a href="{{ url('install/account') }}" class="list-group-item">
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;Account
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    {!! Form::open(['url'=>'installer/database', 'method'=>'POST']) !!}

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">First name</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="admin@domain.com">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Last name</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="admin@domain.com">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Email address</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="admin@domain.com">
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

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Repeat password</label>
            </div>
            <div class="col-md-8">
                <input type="password" class="form-control" placeholder="password">
            </div>
        </div>

    </form>

@stop

@section('button-bar')

    <a href="{{ url('install/finished') }}" class="btn btn-primary pull-right">
        Install application&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
    </a>

@stop