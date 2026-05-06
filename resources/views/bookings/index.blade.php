@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-calendar-check"></i> МОИ БРОНИРОВАНИЯ
                </h5>
                <a href="{{ route('bookings.create') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-plus-circle"></i> НОВОЕ БРОНИРОВАНИЕ
                </a>
            </div>
        </div>
        <div class="card-body bg-white">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($bookings->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x display-1 text-black-50"></i>
                    <h4 class="text-dark mt-3">У вас пока нет бронирований</h4>
                    <p class="text-secondary">Создайте новое бронирование, чтобы забронировать столик</p>
                    <a href="{{ route('bookings.create') }}" class="btn btn-dark mt-2">
                        <i class="bi bi-plus-circle"></i> ЗАБРОНИРОВАТЬ СТОЛИК
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($bookings as $booking)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 border booking-card">
                            <div class="card-header bg-white border-0 pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill px-3 py-2 
                                        @if($booking->status == 'pending') bg-secondary text-white
                                        @elseif($booking->status == 'confirmed') bg-dark text-white
                                        @else bg-light text-dark border
                                        @endif">
                                        @if($booking->status == 'pending')
                                            <i class="bi bi-clock-history"></i> ОЖИДАЕТ
                                        @elseif($booking->status == 'confirmed')
                                            <i class="bi bi-check-circle"></i> ПОДТВЕРЖДЕНО
                                        @else
                                            <i class="bi bi-x-circle"></i> ОТМЕНЕНО
                                        @endif
                                    </span>
                                    <small class="text-secondary">#{{ $booking->id }}</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar3 text-dark me-2"></i>
                                        <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-clock text-dark me-2"></i>
                                        <span class="text-dark">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person text-dark me-2"></i>
                                        <span class="text-dark">{{ $booking->guests_count }} гостей</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-table text-dark me-2"></i>
                                        <span class="text-dark">{{ $booking->table->name }} ({{ $booking->table->seats }} мест)</span>
                                    </div>
                                </div>
                                
                                @if($booking->menuItems->count() > 0)
                                <div class="border-top pt-2 mt-2">
                                    <small class="text-secondary">
                                        <i class="bi bi-cup-straw"></i> Заказано блюд: {{ $booking->menuItems->count() }}
                                    </small>
                                    <div class="fw-bold text-dark mt-1">
                                        {{ number_format($booking->total_price, 2) }} руб.
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="card-footer bg-white border-0 pb-3">
                                @if($booking->status != 'cancelled' && $booking->status != 'confirmed')
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Отменить бронирование?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-dark btn-sm w-100">
                                        <i class="bi bi-x-circle"></i> ОТМЕНИТЬ
                                    </button>
                                </form>
                                @elseif($booking->status == 'confirmed')
                                <button class="btn btn-dark btn-sm w-100" disabled>
                                    <i class="bi bi-check-circle"></i> ПОДТВЕРЖДЕНО
                                </button>
                                @else
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    <i class="bi bi-x-circle"></i> ОТМЕНЕНО
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.booking-card {
    border: 1px solid #dee2e6 !important;
    transition: box-shadow 0.2s ease;
}
.booking-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}
.btn-outline-dark {
    border: 1px solid #000000;
    color: #000000;
    background: transparent;
}
.btn-outline-dark:hover {
    background: #000000;
    color: #ffffff;
}
.btn-dark {
    background: #000000;
    border: 1px solid #000000;
    color: #ffffff;
}
.btn-dark:hover {
    background: #333333;
    border-color: #333333;
}
.btn-outline-light {
    border: 1px solid #ffffff;
    color: #ffffff;
}
.btn-outline-light:hover {
    background: #ffffff;
    color: #000000;
}
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
.text-black-50 {
    color: rgba(0,0,0,0.5) !important;
}
.bg-secondary {
    background-color: #6c757d !important;
}
.bg-dark {
    background-color: #000000 !important;
}
.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection