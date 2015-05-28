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
                &nbsp;<i class="fa fa-angle-right"></i>&nbsp;
                Snapshot History

                <a href="{{ url('app/cash') }}" class="btn-back">Go Back</a>
            </h2>
    	</div>

    	<div class="paper-body">

            @if( count($snapshots) == 0 )

                <div class="empty-announcement">
                    <div class="fa fa-archive"></div>
                    <h2>No snapshot history</h2>
                </div>

            @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($snapshots as $snapshot)

                    <tr>
                        <td>
                            {{ $snapshot->snapshot_title }}<br>
                            <i>{{ $snapshot->description }}</i>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            @endif

    	</div>

    </div>

@stop

@section('custom-js')

@stop