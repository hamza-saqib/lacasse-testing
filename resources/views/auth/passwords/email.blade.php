@extends('layouts.front.app')

@section('content')
<div class="container">
    <div class="row">
       <div class="col-md-8 offset-md-2">
            <div class="panel panel-default login-form">
                <h2>{{LanguageHelper::getPhrase('reset_password')}}</h2>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ LanguageHelper::getPhrase('we_have_e-mailed_your_password_reset_link') }}!
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{LanguageHelper::getPhrase('reset_e-mail_address')}}" required>
                            <div class="error-msg">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{LanguageHelper::getPhrase('send_password_reset_link')}}</button>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
