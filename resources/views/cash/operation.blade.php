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
                New Operation

                <a href="{{ url('app/cash') }}" class="btn-back">Go Back</a>
    		</h2>
    	</div>

    	<div class="paper-body">

            {!! Form::open(['url'=>'app/cash/register-operation', 'method'=>'POST']) !!}

                <div class="col-md-4 col-md-offset-4" style="margin-top:30px;margin-bottom:50px;">
                    
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount" placeholder="0">

                    <a href="{{ url('app/cash') }}" class="btn btn-default pull-left">Cancel</a>
                    <input type="submit" class="btn btn-success pull-right" value="Register Operation">
               
                </div>

            </form>

    	</div>

    </div>

@stop

@section('custom-js')

@stop