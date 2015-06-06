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

                <div class="col-md-8 col-md-offset-2" style="margin-bottom:50px;margin-top:40px;">

                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Snapshot Title" value="{{ old('title') }}">

                    <label>Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Snapshot Description" value="{{ old('description') }}">

                    <label>Current Amount</label>
                    <input type="text" class="form-control" name="amount" placeholder="0" value="{{ old('amount') }}">

                    <div class="alert alert-info">
                        <span class="fa fa-lightbulb-o"></span>&nbsp;
                        Remember that creating a new cash snapshot will close the previous one.
                    </div>

                    <a href="{{ url('app/cash') }}" class="btn btn-default pull-left">Cancel</a>
                    <input type="submit" class="btn btn-success pull-right" value="Create new cash snapshot">

                </div>

            </form>

    	</div>

    </div>

@stop

@section('custom-js')

@stop