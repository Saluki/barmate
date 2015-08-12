@extends('layouts.app')

@section('title')
    Cash Management - Barmate POS
@stop

@section('custom-css')

    <link rel="stylesheet" type="text/css" href="{{ url('build/css/cash.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/alertify-js/build/css/alertify.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/css/alertify-theme.css') }}" />

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
                        <h2>
							{{ str_limit($snapshot->snapshot_title,20) }} <span class="text-primary">#{{ $snapshot->cs_id }}</span>
						</h2>
                    </div>
                    <div class="col-md-7" style="padding-top:20px;">

                        <a href="{{ url('app/cash/new-snapshot') }}" class="btn btn-default pull-right">
                            <span class="fa fa-camera"></span>&nbsp;&nbsp;Create snapshot
                        </a>

                        <div class="dropdown pull-right" style="margin-right:20px;">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                <span class="fa fa-history"></span>&nbsp;
                                History
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">

                                @if( count($allSnapshots)>10 )

                                    @for($i=0; $i<10; $i++)

                                        @if($allSnapshots[$i]->cs_id === $snapshot->cs_id)
                                            <li role="presentation" class="disabled">
                                                <a role="menuitem" tabindex="-1" href="#">
                                                    {{ $allSnapshots[$i]->snapshot_title }}&nbsp;&nbsp;
                                                    <span class="text-primary">#{{ $allSnapshots[$i]->cs_id }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="{{ url('app/cash/'.$allSnapshots[$i]->cs_id) }}">
                                                    {{ $allSnapshots[$i]->snapshot_title }}&nbsp;&nbsp;
                                                    <span class="text-primary">#{{ $allSnapshots[$i]->cs_id }}</span>
                                                </a>
                                            </li>
                                        @endif

                                    @endfor

                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#" id="older-snapshots-btn">
                                            Older snapshots
                                        </a>
                                    </li>

                                @else

                                    @foreach($allSnapshots as $tempSnapshot)

                                        @if($tempSnapshot->cs_id === $snapshot->cs_id)
                                            <li role="presentation" class="disabled">
                                                <a role="menuitem" tabindex="-1" href="#">
                                                    {{ $tempSnapshot->snapshot_title }}&nbsp;&nbsp;
                                                    <span class="text-primary">#{{ $tempSnapshot->cs_id }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="{{ url('app/cash/'.$tempSnapshot->cs_id) }}">
                                                    {{ $tempSnapshot->snapshot_title }}&nbsp;&nbsp;
                                                    <span class="text-primary">#{{ $tempSnapshot->cs_id }}</span>
                                                </a>
                                            </li>
                                        @endif

                                    @endforeach

                                @endif

                            </ul>
                        </div>

                        @if( !$snapshot->is_closed )
                            <a href="{{ url('app/cash/register-operation') }}" class="btn btn-default pull-right" style="margin-right:20px;">
                                <span class="fa fa-dollar"></span>&nbsp;&nbsp;Register operation
                            </a>
                        @else
                            <div class="label label-danger pull-right" style="margin-right:20px;padding:10px;font-size: 13px;">Snapshot closed</div>
                        @endif

                    </div>
                </div>
                <br>

                @if( $snapshot->is_closed )

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><span class="fa fa-lock"></span>&nbsp;&nbsp;Closed snapshot summary</h2>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">

                            <div class="stat-tile">
                                <div class="stat-title">Snapshot duration</div>
                                <div class="stat-number">
                                   {{ $duration }}
                                </div>
                            </div>

                            <div class="stat-tile">
                                <div class="stat-title">Next Snapshot Difference</div>
                                <div class="stat-number">
                                    @if( $delta<=0 )
                                        {{ number_format($delta,2) }}€
                                    @elseif( $delta>0 )
                                        +{{ number_format($delta,2) }}€
                                    @endif

                                </div>
                            </div>

                            <div class="stat-tile">
                                <div class="stat-title">Cash By Sales</div>
                                <div class="stat-number">+{{ number_format($cashBySales,2) }}€</div>
                            </div>

                        </div>
                    </div>

                @else

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title"><span class="fa fa-heartbeat"></span>&nbsp;&nbsp;Heartbeat</h2>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                            <div class="stat-tile">
                                <div class="stat-title">Last Cash Operation</div>
                                <div class="stat-number">
                                    @if( $lastOperation>0 )+@endif{{ number_format($lastOperation,2) }}€
                                </div>
                            </div>
                            <div class="stat-tile">
                                <div class="stat-title">Cash In Drawer</div>
                                <div class="stat-number">{{ number_format(end($amounts),2) }}€</div>
                            </div>

                            <div class="stat-tile">
                                <div class="stat-title">Cash By Sales</div>
                                <div class="stat-number">+{{ number_format($cashBySales,2) }}€</div>
                            </div>

                        </div>
                    </div>

                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title"><span class="fa fa-archive"></span>&nbsp;&nbsp;Snapshot data</h2>
                    </div>
                    <div class="panel-body">

                        @if( count($details)==0 )
							
							<div id="init-container">
								<div class="fa fa-archive"></div>

								<div class="intro-text">
									This snapshot has no cash operations or sales.
								</div>

                                @unless($snapshot->is_closed)
                                    <a href="{{ url('app/cash/register-operation') }}" class="btn btn-primary btn-lg">Register a cash operation</a>
                                @endunless

                            </div>
												
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
                                        <th></th>
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
                                            <td>{{ date('j F Y G:i', strtotime($detail->timed)) }}</td>
                                            <td>{{ $detail->firstname }} {{ $detail->lastname }}</td>
                                            <td>{{ str_limit($detail->comment,30) }}</td>
                                            <td>
                                                @unless( $snapshot->is_closed )

                                                    <a href="{{ url('app/cash/remove/'.$detail->csd_id) }}" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="top" title="Definitely remove snapshot item">
                                                        Remove
                                                    </a>

                                                @endif
                                            </td>
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

    <script src="{{ url('bower_components/chartjs/Chart.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/alertify-js/build/alertify.min.js') }}"></script>

    <script type="text/template" id="snapshot-modal-template">

        <br>
        <div class="list-group" id="snapshot-modal-list">
            @foreach($allSnapshots as $sn)

                <a href="{{ url('app/cash/'.$sn->cs_id) }}" class="list-group-item
                @if($sn->cs_id==$snapshot->cs_id)
                    disabled
                @endif
                ">
                    {{ $sn->snapshot_title }}&nbsp;&nbsp;
                    <span class="text-primary">#{{ $sn->cs_id }}</span>
                </a>

            @endforeach
        </div>

    </script>

    <script src="{{ url('build/js/cash.js') }}"></script>

@stop
