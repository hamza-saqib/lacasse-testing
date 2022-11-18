<!DOCTYPE html>

<html lang="en">

<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS') }}"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());



        gtag('config', '{{ env('GOOGLE_ANALYTICS') }}');

    </script>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- <title>lacassemaroc.ma</title> -->

    <meta name="description" content="{{ config('app.name') }}">

    <meta name="author" content="{{ config('app.name') }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="{{ asset('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>

    <script src="{{ asset('https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>

    <![endif]-->

    <!-- <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png')}}">

    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png')}}">

    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png')}}">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png')}}">

    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png')}}">

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png')}}">

    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png')}}">

    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png')}}">

    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png')}}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png')}}">

    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png')}}">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png')}}"> -->

    <!-- <link rel="manifest" href="{{ asset('favicons/manifest.json')}}">

    <meta name="msapplication-TileColor" content="#ffffff">

    <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png')}}">

    <meta name="theme-color" content="#ffffff"> -->

    @yield('css')

    <meta property="og:url" content="{{ request()->url() }}"/>

    @yield('og')

    {{-- whatsapp button style --}}
    <style>
      .float {
          position: fixed;
          width: 60px;
          height: 60px;
          bottom: 20px;
          right: 20px;
          background-color: #25d366;
          color: #FFF;
          border-radius: 45px;
          text-align: center;
          font-size: 30px;
          /* box-shadow: 2px 2px 3px #999; */
          z-index: 100;
      }

      .my-float {
          margin-top: 16px;
      }
  </style>

</head>

<body>

    <div class="background-full">

        <img src="{{asset('images/bg_body_wings_blue.png')}}" alt="">

    </div>

        <div class="white-bg">

            <header>

    <div class="container">

                 <div class="top-bar">

                    <div class="right-area">

                       <span>

                       <!-- <a href="#"><img src="{{asset('images/se.png')}}"></a>

                       <a href="#"><img src="{{asset('images/no.png')}}"></a> -->

                       <a href="{{url('language/en')}}"><img src="{{asset('images/uk.png')}}"></a>

                       <a href="{{url('language/fr')}}"><img src="{{asset('images/france.png')}}"></a>

                       <!-- <a href="#"><img src="images/dk.png"></a>

                       <a href="#"><img src="images/dk.png"></a> -->

                       </span>

                       <!-- <ul>

                          <li><a href="#">About Bildelsbasen.se</a></li>

                          <li><a href="#">Affiliated companies</a></li>

                          <li><a href="#">Feedback</a></li>

                       </ul> -->

                    </div>

                    <div class="login-area">

                        @if(auth()->check())

                            <a href="{{ route('accounts', ['tab' => 'profile']) }}">{{LanguageHelper::getPhrase('my_account')}}</a>

                            <a href="{{ route('logout') }}">{{LanguageHelper::getPhrase('logout')}}</a>

                        @else

                            <a href="{{ route('login') }}">{{LanguageHelper::getPhrase('log_in')}}</a>

                            <a href="{{ url('password/reset') }}">{{LanguageHelper::getPhrase('forgot_password')}}?</a>

                            <a href="{{ route('register') }}">{{LanguageHelper::getPhrase('register')}}</a>

                        @endif

                           {{-- <a href="{{ route('cart.index') }}">{{ $cartCount }}</a> --}}

                    </div>

                 </div>

                 <div class="logo">

                    <a href="{{url('/')}}"><img src="{{asset('images/logo-new.png')}} ">lacassemaroc</a>

                 </div>

                 <nav class="navbar navbar-expand-lg navbar-light bg-gradient">

                    <!-- <a class="navbar-brand" href="#">Navbar</a> -->

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                       <ul class="navbar-nav mr-auto">

                          <li class="nav-item active">

                             <a class="nav-link" href="{{ url('/') }}"> {{LanguageHelper::getPhrase('home')}} <span class="sr-only">(current)</span></a>

                          </li>

                          <li class="nav-item">

                            @if(auth()->check())

                              <a class="nav-link" href="{{ url('accounts?tab=orders')}}"> {{LanguageHelper::getPhrase('my_order')}}({{ getUserOrders(auth()->user()->id) }})</a>

                            @else

                              <a class="nav-link" href="{{ url('accounts?tab=orders')}}"> {{LanguageHelper::getPhrase('my_order')}}(0)</a>

                            @endif

                          </li>

                          <li class="nav-item">

                             <a class="nav-link" href="{{ route('cart.index') }}"> {{LanguageHelper::getPhrase('saved_part')}}({{ $cartCount }}) </a>

                          </li>

                          <li class="nav-item">

                             <a class="nav-link" href="{{ route('front.show.wishlist') }}"> {{LanguageHelper::getPhrase('wishlist')}} </a>

                          </li> 

                          <!-- <li class="nav-item">

                             <a class="nav-link" href="#">Saved searches(0)</a>

                          </li> -->

                       </ul>

                       {{--

                       <form class="form-inline my-lg-0">

                          <input class="form-control " type="search" placeholder="Ert Z-Nummer" aria-label="Search">

                          <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->

                       </form>

                       --}}

                    </div>

                 </nav>

              </div>

            </header>

            <main>

              <div class="container">

            @yield('content')

          </div>

          </main>

            @include('layouts.front.footer')

        </div>

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@yield('js')
   <a href="https://api.whatsapp.com/send?phone=212630079587&text=Hi,%20I%20am%20looking%20for%20Car%20Parts."
        class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
</body>

</html>

{{-- 

    {{ config('app.name') }}

    {{ route('home') }} 

    @include('layouts.front.header-cart')  

--}}

 