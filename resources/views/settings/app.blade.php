@extends('layouts.app')

@section('title')

    Barmate Settings - Barmate POS

@stop

@section('custom-css')

@stop

@section('content')

	<div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-wrench"></i>&nbsp;&nbsp;
    			Barmate Settings
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

            <div class="col-md-12">

                <h2>Application Settings</h2>

            </div>

    	</div>

    </div>

@stop

@section('custom-js')

@stop