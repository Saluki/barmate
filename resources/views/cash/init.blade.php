@extends('layouts.app')

@section('title')
    Cash Management - Barmate POS
@stop

@section('custom-css')
    <link rel="stylesheet" type="text/css" href="{{ url('build/css/cash.css') }}">
@stop

@section('content')

    <div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-bank"></i>&nbsp;&nbsp;
    			Cash Management
    		</h2>
    	</div>

    	<div class="paper-body">

            <div id="init-container">
                <div class="fa fa-bank"></div>

                <div class="intro-text">
                    Start registering your sales by creating a new cash snapshot.
                </div>

                <a href="{{ url('app/cash/new-snapshot') }}" class="btn btn-primary btn-lg">Create a cash snapshot</a>
            </div>

    	</div>

    </div>

@stop

@section('custom-js')

@stop