@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-3">ДОБРО ПОЖАЛОВАТЬ</h1>
            <p class="lead mb-4">Забронируйте столик в нашем ресторане</p>
            
            @guest
                <a href="{{ route('register') }}" class="btn btn-black btn-lg me-2">ЗАБРОНИРОВАТЬ</a>
                <a href="{{ route('login') }}" class="btn btn-outline-black btn-lg">ВОЙТИ</a>
            @else
                <a href="{{ route('bookings.create') }}" class="btn btn-black btn-lg me-2">ЗАБРОНИРОВАТЬ</a>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-black btn-lg">МОИ БРОНИРОВАНИЯ</a>
            @endguest
        </div>
    </div>
</div>
@endsection