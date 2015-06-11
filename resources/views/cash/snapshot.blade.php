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
    		</h2>
    	</div>

        @if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @endif

    	<div class="paper-body">

            <div class="col-md-6">
                <h2>Create a new snapshot</h2>
            </div>

            <div class="col-md-6">
                <a href="{{ url('app/cash') }}" class="btn btn-default pull-right" style="margin-top:20px;">
                    <span class="fa fa-times"></span>&nbsp;&nbsp;Cancel
                </a>
            </div>

            {!! Form::open(['url'=>'app/cash/new-snapshot', 'method'=>'POST']) !!}

                <div class="col-md-12" style="margin-bottom:50px;margin-top:20px;">

                    <div class="alert alert-danger">
                        <span class="fa fa-warning"></span>&nbsp;
                        <b>Watch out.</b> Remember that creating a new cash snapshot will close the previous one.
                    </div>

                    <label>Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Snapshot Title" value="{{ old('title') }}" autocomplete="off">

                    <label>Description <i class="text-info">(optional)</i></label>
                    <input type="text" class="form-control" name="description" placeholder="Snapshot Description" value="{{ old('description') }}">

                    <label>Current Amount</label>
                    <input type="text" class="form-control" name="amount" placeholder="0" value="{{ old('amount') }}" autocomplete="off">
                    <br>
                    <input type="submit" class="btn btn-danger pull-right" value="Create new cash snapshot">

                </div>

            </form>

    	</div>

    </div>

@stop

@section('custom-js')

@stop