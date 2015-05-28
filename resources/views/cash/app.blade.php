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

            <div class="col-md-12" id="current-snapshot">
                <div class="row">

            		<div class="col-md-8" id="current-snapshot-graph" style="padding-top:10px;">
                    
                        @if( count($amounts) <= 1 )

                            <div class="empty-announcement">
                                <div class="fa fa-line-chart"></div>
                                <h2>
                                    No data for this snapshot
                                </h2>
                                <h3>
                                    Register a <a href="{{ url('app/cash/register-operation') }}">cash operation</a> or a <a href="{{ url('app') }}">sale</a>
                                </h3>
                            </div>

                        @else

                            <div id="graph-title" style="font-style:italic;padding-left:40px;font-size:17px;font-weight:bold;">
                                Cash evolution since snapshot
                            </div>
                            <canvas id="graph-area"></canvas>

                        @endif

                    </div>

                    <div class="col-md-4" id="current-snapshot-details">
                    
                        <br>
                        <span class="label label-danger" style="font-size:15px;">Current Snapshot</span>
                        <h3>{{ $repository->snapshot_title }}</h3>
                        <i>{{ $repository->description }}</i>

                        <br><br>
                        <b>Begin Time</b>
                        <br>
                        {{ date('j F Y G:i', strtotime($repository->time)) }}

                        <br><br>
                        <b>Start Amount</b>
                        <br>
                        {{ $repository->amount }}€

                    </div>

                </div>
            </div>

            <!-- ACTION HEADER -->
            <div class="col-md-12">
                <div class="row group-title">

                    <div class="col-md-2 group-title-text">  
                        <span class="fa fa-magic"></span>&nbsp;Actions
                    </div>

                    <div class="col-md-9 group-title-line"></div>

                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="col-md-12">

                <a class="action-tile" href="{{ url('app/cash/register-operation') }}">

                    <div class="action-icon">
                        <span class="fa fa-exchange"></span>
                    </div>

                    <div class="action-text">
                        Cash Operation
                    </div>

                </a>

                <a class="action-tile" href="{{ url('app/cash/new-snapshot') }}">

                    <div class="action-icon">
                        <span class="fa fa-map-marker"></span>
                    </div>

                    <div class="action-text">
                        New Snapshot
                    </div>

                </a>
                
                <a class="action-tile" href="{{ url('app/cash/history') }}">

                    <div class="action-icon">
                        <span class="fa fa-history"></span>
                    </div>

                    <div class="action-text">
                        Show History
                    </div>

                </a>

            </div>

            <!-- STATISTICS HEADER -->
            <div class="col-md-12">
                <div class="row group-title">

                    <div class="col-md-2 group-title-text">  
                        <span class="fa fa-pie-chart"></span>&nbsp;Statistics
                    </div>

                    <div class="col-md-9 group-title-line"></div>

                </div>
            </div>

            <!-- STATISTICS -->
            <div class="col-md-12" style="margin-bottom:30px;">

                <div class="stat-tile">
                    <div class="stat-title">Last Cash Operation</div>
                    <div class="stat-number">
                        @if( $lastOperation>0 )
                            +{{ $lastOperation }}€
                        @else
                            {{ $lastOperation }}€
                        @endif
                    </div>
                </div>

                 <div class="stat-tile">
                 <div class="stat-title">Cash In Drawer</div>
                    <div class="stat-number">{{ end($amounts) }}€</div>
                </div>

                <div class="stat-tile">
                    <div class="stat-title">Cash By Sales</div>
                    <div class="stat-number">+{{ $cashBySales }}€</div>
                </div>

            </div>

    	</div>

    </div>

@stop

@section('custom-js')

    <script type="text/javascript" src="{{ url('bower_components/chartjs/Chart.min.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            var canvas = document.getElementById("graph-area");
            canvas.width = $("#current-snapshot-graph").width();
            canvas.height = $("#current-snapshot-graph").height()-$("#graph-title").height();

            var data = {
                labels: [@foreach($amounts as $amount=>$sum) "", @endforeach],
                datasets: [{
                    label: "My First dataset",
                    fillColor: "#E6F2F8",
                    strokeColor: "#0095DD",
                    pointColor: "#0095DD",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [@foreach($amounts as $amount=>$sum) {{ $sum }}, @endforeach]
                }]
            };

            var chartOptions = {

                animation: false,
                scaleShowGridLines : false,
                bezierCurve : false,
                datasetStroke : false,
                scaleGridLineColor : "#fff",
                scaleShowLabels : true,
                tooltipTemplate: "<%if (label){%><%=label%>: <%}%>Cash in drawer: <%= value %>€",
            };

            new Chart( canvas.getContext("2d") ).Line(data, chartOptions);
        });

    </script>

@stop