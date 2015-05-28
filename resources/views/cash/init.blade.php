@extends('layouts.app')

@section('title')
    Cash Management | Barmate
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

           <b>Hello There. Time to create a new snapshot</b>

           <br><br>

           <a href="{{ url('app/cash/new-snapshot') }}">Create a new snapshot</a>

    	</div>

    </div>

@stop

@section('custom-js')

@stop