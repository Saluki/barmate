@extends('layouts.public')

@section('content')

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            
            {!! Form::open(['url'=>'login', 'method'=>'POST']) !!}
                
                <label>Email</label><br>
                <input class="form-control" name="email" type="text" placeholder="Email" value="{{ Session::get('email') }}"><br>
                
                <label>Password</label><br>
                <input class="form-control" name="password" type="password" placeholder="Password"><br>
                
                <input type="submit" value="Log in" class="btn btn-primary pull-right">
                
            </form>
        
            <div class="clearfix" style="margin-top:50px;"></div>
                        
            @if( Session::has('error') )

                <p class="alert alert-info">
                    {{ Session::get('error') }}
                </p>

            @endif
                            
        </div>
    </div>

@stop