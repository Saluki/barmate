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
    			<a href="{{ url('app/cash') }}">Cash Management</a>
                &nbsp;<span class="fa fa-angle-right"></span>&nbsp;
                New Snapshot

                <a href="{{ url('app/cash') }}" class="btn-back">Go Back</a>
    		</h2>
    	</div>

        @if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @endif

    	<div class="paper-body">

            {!! Form::open(['url'=>'app/cash/new-snapshot', 'method'=>'POST']) !!}

                <div class="col-md-4 col-md-offset-4" style="margin-bottom:30px;">

                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Snapshot Title">

                    <label>Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Snapshot Description">

                    <label>Start Amount</label>
                    <input type="text" class="form-control" name="amount" placeholder="0">

                    <a href="{{ url('app/cash') }}" class="btn btn-default pull-left">Cancel</a>
                    <input type="submit" class="btn btn-success pull-right" value="Create">

                </div>

            </form>

    	</div>

    </div>

@stop

@section('custom-js')

@stop