@extends('layouts.public')

@section('title')
    Login - Barmate POS
@stop

@section('custom-css')

    <link rel="stylesheet" href="{{ url('build/css/common.css') }}">
    <link rel="stylesheet" href="{{ url('build/css/login.css') }}">

@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="login-header">
                <span class="logo-title">
                    Barmate&nbsp;&nbsp;
                </span>
                <span class="logo-subtitle">
                    Sign In
                </span>
            </div>

            {!! Form::open(['url'=>' ', 'method'=>'POST']) !!}

                <label>Email</label><br>
                <input class="form-control" id="email-input" name="email" type="text" placeholder="Email" value="{{ Session::get('email') }}">

                <label>Password</label><br>
                <input class="form-control" id="password-input" name="password" type="password" placeholder="Password">

                @if( Session::has('error') )

                    <p class="alert alert-info">
                        <span class="fa fa-warning"></span>&nbsp;
                        {{ Session::get('error') }}
                    </p>

                @endif

                <button type="submit" class="btn btn-primary pull-right">
                    <span class="fa fa-sign-in"></span>&nbsp;&nbsp;
                    Sign in
                </button>

            </form>

        </div>
    </div>

@stop

@section('custom-js')

    <script>

        $(document).ready(function(){

            var emailInput = $('#email-input');
            var passwordInput = $('#password-input');

            if( emailInput.val() == "" ) {
                emailInput.focus();
            }
            else {
                passwordInput.focus();
            }

        });

    </script>

@stop