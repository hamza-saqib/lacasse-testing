@extends('layouts.front.app')

@section('content')
<div class="container">
    <div class="row">
       <div class="col-md-8 offset-md-2">
            <div class="panel panel-default login-form">
                <h2>{{LanguageHelper::getPhrase('reset_password')}}</h2>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->
                            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="{{LanguageHelper::getPhrase('reset_email')}}" required autofocus>
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
                            <input id="password" type="password" class="form-control" name="password" required placeholder="{{LanguageHelper::getPhrase('reset_reset_password')}}">
                            <div class="error-msg">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <!-- <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label> -->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{LanguageHelper::getPhrase('reset_reset_confirm_password')}}" required>
                            <div class="error-msg">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{LanguageHelper::getPhrase('reset_password_button')}}</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
