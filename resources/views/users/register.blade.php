@extends('layouts.app')

@section('title')

    New Account - Barmate POS

@stop

@section('custom-css')

@stop

@section('content')

	<div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-users"></i>&nbsp;&nbsp;
    			<a href="{{ url('app/users') }}">User Accounts</a>
    			 &nbsp;<span class="fa fa-angle-right"></span>&nbsp;
    			Add New Account
            </h2>
    	</div>
    	
    	@if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @elseif ( Session::has('success') )

            <div class="paper-notify success">
                <i class="fa fa-check"></i>&nbsp; {{ Session::get('success') }}
            </div>

        @endif

    	<div class="paper-body">

            <div class="col-md-6">
                <h2>Add a new user account</h2>
                <br>
            </div>

            <div class="col-md-6">
                <a href="{{ url('app/users') }}" class="btn btn-default pull-right" style="margin-top:20px;">
                    <span class="fa fa-times"></span>&nbsp;&nbsp;Cancel
                </a>
            </div>

            <div class="col-md-12">
                <div class="row" style="padding-bottom:30px;">
                    {!! Form::open(['method'=>'POST', 'url'=>'app/users/register']) !!}

                        <div class="col-md-6">
                                <label>First name</label>
                                <input type="text" name="firstname" class="form-control" placeholder="Firstname">
                        </div>
                        <div class="col-md-6">
                                <label>Last name</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Lastname">
                        </div>
                        <div class="col-md-12 clearfix">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email address">

                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">

                                <label>Account role</label>
                                <select class="form-control" name="role">
                                    <option value="USER">User Account - Only access to bar application</option>
                                    <option value="MNGR">Manager Account - Extended management rights</option>
                                </select>

                                <br>
                                <input type="submit" class="btn btn-success pull-right" value="Add new account">

                        </div>

                    </form>
                </div>
            </div>
    		
    	</div>

    </div>
    
@stop

@section('custom-js')

@stop