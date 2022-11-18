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
            Oups! Votre transaction a échoué. Veuillez essayer après un certain temps.
        </div>
        <a href="{{ route('home') }}" class="btn btn-default">Retourner</a>
    </div>
</div>
@endsection