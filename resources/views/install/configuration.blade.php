@extends('layouts.install')

@section('title')
    Configuration
@stop

@section('side-menu')

    <a href="#" class="list-group-item disabled">
        <span class="fa fa-magic"></span>&nbsp;&nbsp;&nbsp;Welcome
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-server"></span>&nbsp;&nbsp;&nbsp;Requirements
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-database"></span>&nbsp;&nbsp;&nbsp;Database
    </a>
    <a href="{{ url('install/configuration') }}" class="list-group-item">
        <span class="fa fa-wrench"></span>&nbsp;&nbsp;&nbsp;Configuration
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;Account
    </a>
    <a href="#" class="list-group-item disabled">
        <span class="fa fa-rocket"></span>&nbsp;&nbsp;&nbsp;Finished
    </a>

@stop

@section('content')

    {!! Form::open(['url'=>'install/configuration', 'method'=>'POST']) !!}

        @if( count($errors)>0 )
            <div class="row">
                <div class="col-md-12">

                    <div class="alert alert-warning">
                        <span class="fa fa-warning"></span>&nbsp;&nbsp;
                        @if( count($errors)==1 )
                            {{ $errors->all()[0] }}
                        @else
                            The following <b>validation errors</b> have been found:
                            <ul>
                                @foreach($errors->all() as $validation_error)

                                    <li>{{ $validation_error }}</li>

                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
            <br>
        @endif

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Application URL</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="application_url" value="{{ (old('application_url')) ? old('application_url') : $applicationUrl }}" class="form-control" placeholder="http://localhost">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Encryption key</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="encryption_key" value="{{ (old('encryption_key')) ? old('encryption_key') : $encryptionKey }}" class="form-control" placeholder="towUabLdt6YdA45yPhDsyyGWoLBOrJDo">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label class="pull-right">Timezone</label>
            </div>
            <div class="col-md-8">

                <select name="timezone" class="form-control">
                    @foreach($timezonesId as $identifier)
                        <option value="{{ $identifier }}">{{ $identifier }}</option>
                    @endforeach
                </select>

            </div>
        </div>

        <button type="submit" class="btn btn-primary pull-right" style="margin-top:30px;">
            Create administrator account&nbsp;&nbsp;<span class="fa fa-caret-right"></span>
        </button>

    </form>

@stop

@section('button-bar')

@stop