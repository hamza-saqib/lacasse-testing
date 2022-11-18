@extends('layouts.front.app')

@section('content')
<style>
    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 30px;
    }
</style>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title error404">
            
Merci! Votre commande a réussi. Nous vous tiendrons au courant dès que possible.
        </div>
        <a href="{{ route('home') }}" class="btn btn-default">Retourner</a>
    </div>
</div>
@endsection