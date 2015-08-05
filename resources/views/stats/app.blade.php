@extends('layouts.app')

@section('title')

    Statistics - Barmate POS

@stop

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
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/12h') }}">
                                12 hours
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/24h') }}">
                                24 hours
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/7d') }}">
                                Last 7 days
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ url('app/stats/15d') }}">
                                Last 15 days
                            </a>
                        </li>
                        <li role="presentation">
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
                            <a href="{{ url('app/users') }}">
                                <span class="fa fa-wrench pull-right" data-toggle="tooltip" data-placement="top" title="User accounts"></span>
                            </a>
                        </h2>
                    </div>
                    <div class="panel-body" style="height: 435px;">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:30px;">#</th>
                                    <th>User</th>
                                    <th style="width:100px;">
                                        Sales&nbsp;&nbsp;<span class="fa fa-sort-amount-desc"></span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $userRank=1; ?>
                                @foreach($users as $rank)
                                    <tr>
                                        <td>{{ $userRank++ }}</td>
                                        <td>{{ $rank->firstname }} {{ $rank->lastname }}</td>
                                        <td>{{ $rank->count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="margin-bottom: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <span class="fa fa-cube"></span>&nbsp;&nbsp;Products
                            <a href="{{ url('app/stock') }}">
                                <span class="fa fa-wrench pull-right" data-toggle="tooltip" data-placement="top" title="Stock management"></span>
                            </a>
                        </h2>
                    </div>
                    <div class="panel-body" style="height:435px;">

                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width:30px;">#</th>
                                <th>Product</th>
                                <th style="width:130px;">
                                    Items sold&nbsp;&nbsp;<span class="fa fa-sort-amount-desc"></span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $productRank=1; ?>
                            @foreach($products as $rank)
                                <tr
                                @if( isset($rank->deleted_at) )
                                    class="danger"
                                @endif
                                >
                                    <td>{{ $productRank++ }}</td>
                                    <td>
                                        {{ $rank->product_name }}
                                        @if( isset($rank->deleted_at) )
                                            &nbsp;&nbsp;
                                            <span class="text-danger">
                                                <span class="fa fa-trash"></span> deleted
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $rank->sale_count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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
        };

    </script>

    <!-- JS Statistics component -->
    <script type="text/javascript" src="{{ asset('build/js/stats.js') }}"></script>

@stop