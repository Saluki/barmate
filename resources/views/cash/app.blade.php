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

            <!-- STATISTICS -->
            <div class="col-md-12" style="margin-bottom:30px;">

                <div class="row">
                    <div class="col-md-5">
                        <h2>{{ $snapshot->snapshot_title }} <span class="text-primary">#{{ $snapshot->cs_id }}</span></h2>
                    </div>
                    <div class="col-md-7" style="padding-top:20px;">

                        <a href="{{ url('app/cash/new-snapshot') }}" class="btn btn-success pull-right">
                            <span class="fa fa-camera"></span>&nbsp;&nbsp;Create snapshot
                        </a>

                        <div class="dropdown pull-right" style="margin-right:20px;">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                <span class="fa fa-history"></span>&nbsp;
                                History
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                @foreach($allSnapshots as $s)
                                    <li role="presentation" @if($s->cs_id === $snapshot->cs_id) class="disabled" @endif>
                                        <a role="menuitem" tabindex="-1" href="{{ url('app/cash/'.$s->cs_id) }}">
                                            {{ $s->snapshot_title }}&nbsp;&nbsp;<span class="text-primary">#{{ $s->cs_id }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if( !$snapshot->is_closed )
                            <a href="{{ url('app/cash/register-operation') }}" class="btn btn-primary pull-right" style="margin-right:20px;">
                                <span class="fa fa-dollar"></span>&nbsp;&nbsp;Register operation
                            </a>
                        @else
                            <div class="label label-danger pull-right" style="margin-right:20px;padding:10px;font-size: 13px;">Snapshot closed</div>
                        @endif

                    </div>
                </div>
                <br>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><span class="fa fa-heartbeat"></span>&nbsp;&nbsp;Heartbeat</h2>
                    </div>
                    <div class="panel-body" style="padding-bottom:30px;">
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

                <br>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><span class="fa fa-archive"></span>&nbsp;&nbsp;Snapshot data</h2>
                    </div>
                    <div class="panel-body">

                        @if( count($details)==0 )
                            <h4 class="text-muted" style="text-align: center;">This snapshot has no cash operations or sales.</h4>
                        @else
                            <div class="row" style="margin:10px;text-align: center;">
                                <div class="col-md-6">
                                    <span class="fa fa-circle text-success"></span>&nbsp;&nbsp;<b>{{ $salesCount }}</b> Sales
                                </div>
                                <div class="col-md-6">
                                    <span class="fa fa-circle text-warning"></span>&nbsp;&nbsp;<b>{{ $operationsCount }}</b> Cash operation
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width:{{ ($salesCount/count($details)*100) }}%">
                                </div>
                                <div class="progress-bar progress-bar-warning" style="width:{{ ($operationsCount/count($details)*100) }}%">
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                        <tr>
                                            <td><div class="label
                                            @if( $detail->type === 'SALE' )
                                                label-success
                                            @elseif( $detail->type === 'CASH' )
                                                label-warning
                                            @else
                                                label-default
                                            @endif">{{ $detail->type }}</div></td>
                                            <td>{{ $detail->sum }}€</td>
                                            <td>{{ date('j F Y G:i', strtotime($detail->time)) }}</td>
                                            <td>#{{ $detail->user_id }}</td>
                                            <td>{{ str_limit($detail->comment,20) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>

    	</div>

    </div>

@stop

@section('custom-js')

    <script type="text/javascript" src="{{ url('bower_components/chartjs/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

@stop