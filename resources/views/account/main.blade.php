@extends('layouts.app')

@section('title')

    Account Settings - Barmate POS

@stop

@section('custom-css')

@stop

@section('content')

    <div class="row paper">
        
        <div class="paper-header">
            <h2><i class="fa fa-gear"></i>&nbsp;&nbsp;Account Settings</h2>
        </div>

        @if ( Session::has('error') )

            <div class="paper-notify error">
                <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ Session::get('error') }}
            </div>

        @elseif ( Session::has('success') )

            <div class="paper-notify success">
                <i class="fa fa-check"></i>&nbsp; {{ Session::get('success') }}
            </div>

        @endif
        
        <div class="paper-body">

            {!! Form::open(['url'=>'app/account', 'method'=>'POST']) !!}

                <!-- GENERAL INFORMATIONS -->

                <div class="col-md-4">
                    <label>First name</label>
                    <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}">
                </div>

                <div class="col-md-4">
                    <label>Last name</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}">
                </div>

                <div class="col-md-4">
                    <label>Role</label>
                    <input type="text" class="form-control" disabled value="{{ $user->role }}">
                </div>

                <!-- EMAIL -->

                <div class="col-md-12">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                </div>

                <!-- PASSWORD -->

                <div class="col-md-4">
                    <label>Current password</label>
                    <input type="password" class="form-control" disabled value="password">
                </div>

                <div class="col-md-4">
                    <label>New password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="col-md-4">
                    <label>Repeat new password</label>
                    <input type="password" name="repeat_password" class="form-control">
                </div>

                <!-- NOTES -->

                <div class="col-md-12">

                    <label>About me</label>
                    <textarea class="form-control" name="notes">{{ $user->notes }}</textarea>
                    <br>

                    <input type="submit" class="btn btn-primary pull-right" value="Save settings">

                </div>

                <!-- TRICKY PATCH TO ALLOW PADDING BOTTOM -->
                &nbsp;

            </form>
        
        </div>

    </div>

@stop

@section('custom-js')


@stop