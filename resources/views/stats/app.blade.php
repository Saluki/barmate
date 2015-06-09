@extends('layouts.app')

@section('custom-css')

@stop

@section('content')

	<div class="row paper">

    	<div class="paper-header">
    		<h2>
    			<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;
    			Statistics
    		</h2>
    	</div>

    	<div class="paper-body">

            <div class="label label-danger">In progress...</div>

    	</div>

    </div>

@stop

@section('custom-js')

    <!-- JS Dependencies -->
    <script type="text/javascript" src="{{ url('bower_components/chartjs/Chart.min.js') }}"></script>

    <!-- JS Statistics component -->
    <script type="text/javascript" src="{{ url('build/js/stats.js') }}"></script>

@stop