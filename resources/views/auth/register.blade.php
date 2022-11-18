@extends('layouts.front.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="panel panel-default login-form">
                <h2>{{LanguageHelper::getPhrase('register_register')}}</h2>               
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <!-- <label for="name" class="col-md-4 control-label">Name</label> -->
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{LanguageHelper::getPhrase('register_name')}}" autofocus>
                            <div class="error-msg">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{LanguageHelper::getPhrase('register_email')}}">
                            <div class="error-msg">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <!-- <label for="password" class="col-md-4 control-label">Password</label> -->
                            <input id="password" type="password" class="form-control" name="password" placeholder="{{LanguageHelper::getPhrase('register_password')}}">
                            <div class="error-msg">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label> -->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{LanguageHelper::getPhrase('register_confirm_password')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{LanguageHelper::getPhrase('register_register_button')}}</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
