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
    		</h2>
    	</div>

        @if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @endif

    	<div class="paper-body">

            <div class="col-md-6">
                <h2>Register a new cash operation</h2>
            </div>

            <div class="col-md-6">
                <a href="{{ url('app/cash') }}" class="btn btn-default pull-right" style="margin-top:20px;">
                    <span class="fa fa-times"></span>&nbsp;&nbsp;Cancel
                </a>
            </div>

            {!! Form::open(['url'=>'app/cash/register-operation', 'method'=>'POST']) !!}

                <div class="col-md-12" style="margin-top:20px;margin-bottom:30px;">

                    <div class="alert alert-info">
                        <span class="fa fa-lightbulb-o"></span>&nbsp;
                        <b>Pro tip.</b> To remove money from the cash desk, enter a negative amount.
                    </div>

                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount" placeholder="0">

                    <label>Comment <i class="text-info">(optional)</i></label>
                    <textarea class="form-control" name="comment" placeholder="Describe this operation"></textarea>
                    <br>
                    <input type="submit" class="btn btn-success pull-right" value="Register Operation">
               
                </div>

            </form>

    	</div>

    </div>

@stop

@section('custom-js')

@stop