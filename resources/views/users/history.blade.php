@extends('layouts.app')

@section('title')

    Connection History - Barmate POS

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
    			Connection History
            </h2>
    	</div>

    	<div class="paper-body">

            <div class="col-md-10">
                <h2>{{ $user->firstname }} {{ $user->lastname }}</h2>
                <br>
            </div>

            <div class="col-md-2">
                <a href="{{ url('app/users') }}" class="btn btn-default pull-right" style="margin-top:20px;">
                    <span class="fa fa-times"></span>&nbsp;&nbsp;Back
                </a>
            </div>

            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th>E-mail</th>
                            <th>IP</th>
                            <th>Login&nbsp;&nbsp;<span class="fa fa-caret-down"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($connections as $connection)

                            <tr>
                                <td>{{ $connection->email }}</td>
                                <td>{{ $connection->connect_ip }}</td>
                                <td>
                                    {{ $connection->connect_time }}
                                    &nbsp;&nbsp;
                                    <span class="text-muted">
                                        {{ (new Carbon\Carbon($connection->connect_time))->diffForHumans(Carbon\Carbon::now()) }}
                                    </span>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

                @if( count($connections)==0 )

                    <div id="init-container">
                        <div class="fa fa-user-secret"></div>

                        <div class="intro-text">
                            {{ $user->firstname }} has never logged in before
                        </div>
                    </div>

                @endif

            </div>
    		
    	</div>

    </div>
    
@stop

@section('custom-js')

@stop