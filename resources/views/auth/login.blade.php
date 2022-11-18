@extends('layouts.front.app')

@section('content')
<!--     <hr> -->
    <!-- Main content -->
   <!--  <section class="container content"> -->
    <div class="row">
        <div class="col-md-12">@include('layouts.errors-and-messages')</div>
        <div class="col-md-6 offset-md-3">
            <div class="login-form">
            <h2>{{LanguageHelper::getPhrase('login')}}</h2>
            <form action="{{ route('login') }}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <!-- <label for="email">Email</label> -->
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{LanguageHelper::getPhrase('email')}}" autofocus>
                </div>
                <div class="form-group">
                    <!-- <label for="password">Password</label> -->
                    <input type="password" name="password" id="password" value="" class="form-control" placeholder="{{LanguageHelper::getPhrase('password')}}">
                </div>               
                    <button class="btn btn-default btn-block" type="submit">{{LanguageHelper::getPhrase('login_now')}}</button>
            </form>
            <div class="form-link">
                <a href="{{route('password.request')}}">{{LanguageHelper::getPhrase('i_forgot_my_password')}}</a>
                <a href="{{route('register')}}" class="text-center">{{LanguageHelper::getPhrase('no_account')}}?<b>{{LanguageHelper::getPhrase('register_here')}}.</b></a>
            </div>
            </div>
        </div>
    </div>
        
<!--     </section> -->
    <!-- /.content -->
@endsection
