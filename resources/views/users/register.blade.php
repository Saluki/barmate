@extends('layouts.app')

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
    			
    			<a href="{{ url('app/users') }}" class="btn-back">Go Back</a>
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

            {!! Form::open(['method'=>'POST', 'url'=>'app/users/register']) !!}

                <div style="margin-top:30px;margin-bottom:40px;">
                    <div class="col-md-6">
                            <b>Firstname</b><br>
                            <input type="text" name="firstname" class="form-control" placeholder="Firstname">
                    </div>
                    <div class="col-md-6">
                            <b>Lastname</b><br>
                            <input type="text" name="lastname" class="form-control" placeholder="Lastname">
                    </div>
                    <div class="col-md-12">
                            <b>Email</b><br>
                            <input type="text" name="email" class="form-control" placeholder="Email address">

                            <b>Password</b><br>
                            <input type="password" name="password" class="form-control" placeholder="Password">

                            <b>Account role</b><br>
                            <select class="form-control" name="role">
                                <option value="USER">User Account - Only access to bar application</option>
                                <option value="MNGR">Manager Account - Extended management rights</option>
                            </select>

                            <br>

                            <a href="{{ url('app/users') }}" class="btn btn-default pull-left">Cancel</a>
                            <input type="submit" class="btn btn-success pull-right" value="Add new account">

                    </div>
                </div>

            </form>
    		
    	</div>

    </div>
    
@stop

@section('custom-js')

@stop