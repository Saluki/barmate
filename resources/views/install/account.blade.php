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

    {!! Form::open(['url'=>'install/account', 'method'=>'POST']) !!}

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

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">First name</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="John">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Last name</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Doe">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Email address</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="email_address" value="{{ old('email_address') }}" class="form-control" placeholder="admin@domain.com">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Password</label>
            </div>
            <div class="col-md-8">
                <input type="password" name="password" class="form-control" placeholder="password">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Repeat password</label>
            </div>
            <div class="col-md-8">
                <input type="password" name="repeat_password" class="form-control" placeholder="password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary pull-right" style="margin-top: 30px;">
            Install application&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
        </button>

    </form>

@stop

@section('button-bar')

@stop