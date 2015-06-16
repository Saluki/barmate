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

            <div class="col-md-8">
                <h2>{{ $title }}</h2>
                <br>
            </div>

            <div class="col-md-4">
                <div class="dropdown pull-right" style="margin-top:20px;">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <span class="fa fa-calendar"></span>&nbsp;
                        Change period
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/24h') }}">
                                24 hours
                            </a>
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/7d') }}">
                                Last 7 days
                            </a>
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/30d') }}">
                                Last 30 days
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <span class="fa fa-bar-chart"></span>&nbsp;&nbsp;Sales
                        </h2>
                    </div>
                    <div class="panel-body" style="height:200px;">
                        <canvas id="salesChart" width="860" height="170"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <span class="fa fa-user"></span>&nbsp;&nbsp;Users
                        </h2>
                    </div>
                    <div class="panel-body" style="height:200px;">
                        <!-- -->
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="margin-bottom: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <span class="fa fa-cube"></span>&nbsp;&nbsp;Products
                        </h2>
                    </div>
                    <div class="panel-body" style="height:200px;">
                        <!-- -->
                    </div>
                </div>
            </div>

    	</div>

    </div>

@stop

@section('custom-js')

    <!-- JS Dependencies -->
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/chartjs/Chart.min.js') }}"></script>

    <script type="text/javascript">

        var saleData = {

            labels: [
                @foreach($sales as $saleTime => $saleCount)
                '{{ $saleTime }}',
                @endforeach
            ],

            datasets: [{

                fillColor: "#0088CC",
                data: [
                    @foreach($sales as $saleTime => $saleCount)
                    {{ $saleCount }},
                    @endforeach
                ]
            }]
        }

    </script>

    <!-- JS Statistics component -->
    <script type="text/javascript" src="{{ asset('build/js/stats.js') }}"></script>

@stop