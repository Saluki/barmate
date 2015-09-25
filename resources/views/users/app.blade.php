@extends('layouts.app')

@section('title')

    User Accounts - Barmate POS

@stop

@section('custom-css')

	<link rel="stylesheet" type="text/css" href="{{ url('build/css/users.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/alertify-js/build/css/alertify.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/css/alertify-theme.css') }}" />

@stop

@section('content')

	<div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-users"></i>&nbsp;&nbsp;
    			User Accounts
    		</h2>
    	</div>
    	
    	@if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @elseif ( Session::has('success') )

            <div class="paper-notify success">
                <i class="fa fa-check"></i>&nbsp; {!! Session::get('success') !!}
            </div>

        @endif

    	<div class="paper-body">

            <div class="col-md-6 col-md-offset-6">
    		    <a href="{{ url('app/users/register') }}" class="btn btn-default pull-right" style="margin-top:20px;">
                    <i class="fa fa-user-plus"></i>&nbsp;&nbsp;Add user
                </a>
    	    </div>

            <div class="col-md-12">

                <ul class="nav nav-tabs">
                    @if ($isActive)

                        <li class="active">
                            <a href="#">
                                Active Users&nbsp;&nbsp;
                                <span class="badge">{{ count($users) }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('app/users/disabled') }}">
                                Disabled Users&nbsp;&nbsp;
                                <span class="badge">{{ $otherUsersCount }}</span>
                            </a>
                        </li>

                    @else

                        <li>
                            <a href="{{ url('app/users') }}">
                                Active Users&nbsp;&nbsp;
                                <span class="badge">{{ $otherUsersCount }}</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="#">
                                Disabled Users&nbsp;&nbsp;
                                <span class="badge">{{ count($users) }}</span>
                            </a>
                        </li>

                    @endif
                </ul>

                <br>

                <table class="table" id="users-table">

                    <tbody>
                    @foreach($users as $user)

                        <tr>
                            <td>{{ $user->firstname }} <b>{{ $user->lastname }}</b></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role=='ADMN')
                                    <span class="label label-danger">Administrator</span></h3>
                                @elseif ($user->role=='MNGR')
                                    <span class="label label-warning">Manager</span></h3>
                                @elseif ($user->role=='USER')
                                    <span class="label label-success">User</span></h3>
                                @else
                                    <span class="label label-default">Unknown</span></h3>
                                @endif
                            </td>
                            <td>
                                @if ($user->role!='ADMN')

                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="fa fa-wrench"></span>&nbsp;&nbsp;Actions <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('app/users/connections/'.$user->user_id) }}">Connection history</a></li>
                                            <li><a href="{{ url('app/users/change-role/'.$user->user_id) }}">
                                            @if ($user->role=='USER')
                                                Change role to 'Manager'
                                            @else
                                                Change role to 'User'
                                            @endif
                                            </a></li>
                                            <li><a href="{{ url('app/users/change-status/'.$user->user_id) }}">
                                            @if ($user->is_active)
                                                Disable account
                                            @else
                                                Enable account
                                            @endif
                                            </a></li>
                                            <li class="divider"></li>
                                            <li><a href="{{ url('app/users/delete/'.$user->user_id) }}"><span class="text-danger">Delete account</span></a></li>
                                        </ul>
                                    </div>

                                @else

                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="fa fa-wrench"></span>&nbsp;&nbsp;Actions <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('app/users/connections/'.$user->user_id) }}">Connection history</a></li>
                                        </ul>
                                    </div>

                                @endif

                            </td>
                        </tr>

                    @endforeach
                    </tbody>

                </table>

            </div>

    	</div>

    </div>

@stop

@section('custom-js')

	<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/alertify-js/build/alertify.min.js') }}"></script>

    <script src="{{ url('build/js/users.js') }}"></script>

@stop