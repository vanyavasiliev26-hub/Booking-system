@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-calendar-check"></i> УПРАВЛЕНИЕ БРОНИРОВАНИЯМИ
                </h5>
                <span class="badge bg-light text-dark">{{ $bookings->count() }} всего</span>
            </div>
        </div>
        <div class="card-body bg-white">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">
                    <i class="bi bi-funnel"></i> Фильтр по статусу:
                </label>
                <div class="btn-group flex-wrap gap-2" role="group">
                    <a href="{{ route('admin.bookings', ['status' => 'all', 'sort' => $sort, 'order' => $order]) }}" 
                       class="btn btn-sm {{ $statusFilter == 'all' ? 'btn-dark' : 'btn-outline-dark' }}">
                        <i class="bi bi-grid"></i> Все ({{ $stats['all'] }})
                    </a>
                    <a href="{{ route('admin.bookings', ['status' => 'pending', 'sort' => $sort, 'order' => $order]) }}" 
                       class="btn btn-sm {{ $statusFilter == 'pending' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                        <i class="bi bi-clock"></i> Ожидают ({{ $stats['pending'] }})
                    </a>
                    <a href="{{ route('admin.bookings', ['status' => 'confirmed', 'sort' => $sort, 'order' => $order]) }}" 
                       class="btn btn-sm {{ $statusFilter == 'confirmed' ? 'btn-dark' : 'btn-outline-dark' }}">
                        <i class="bi bi-check-circle"></i> Подтверждены ({{ $stats['confirmed'] }})
                    </a>
                    <a href="{{ route('admin.bookings', ['status' => 'cancelled', 'sort' => $sort, 'order' => $order]) }}" 
                       class="btn btn-sm {{ $statusFilter == 'cancelled' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                        <i class="bi bi-x-circle"></i> Отменены ({{ $stats['cancelled'] }})
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 60px">
                                <a href="{{ route('admin.bookings', ['status' => $statusFilter, 'sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-white fw-semibold">
                                    ID
                                    @if($sort == 'id')
                                        <span class="ms-1">{{ $order == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-white">Клиент</th>
                            <th class="text-white">Столик</th>
                            <th class="text-white">
                                <a href="{{ route('admin.bookings', ['status' => $statusFilter, 'sort' => 'booking_date', 'order' => ($sort == 'booking_date' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-white fw-semibold">
                                    Дата
                                    @if($sort == 'booking_date')
                                        <span class="ms-1">{{ $order == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-white">
                                <a href="{{ route('admin.bookings', ['status' => $statusFilter, 'sort' => 'booking_time', 'order' => ($sort == 'booking_time' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-white fw-semibold">
                                    Время
                                    @if($sort == 'booking_time')
                                        <span class="ms-1">{{ $order == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center text-white">
                                <a href="{{ route('admin.bookings', ['status' => $statusFilter, 'sort' => 'guests_count', 'order' => ($sort == 'guests_count' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-white fw-semibold">
                                    Гостей
                                    @if($sort == 'guests_count')
                                        <span class="ms-1">{{ $order == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-white">
                                <a href="{{ route('admin.bookings', ['status' => $statusFilter, 'sort' => 'status', 'order' => ($sort == 'status' && $order == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-white fw-semibold">
                                    Статус
                                    @if($sort == 'status')
                                        <span class="ms-1">{{ $order == 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center text-white" style="width: 180px">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr class="booking-row">
                            <td class="text-center fw-bold">#{{ $booking->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $booking->table->name }}</span>
                                <br><small class="text-muted">{{ $booking->table->seats }} места</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                            <td class="text-center">
                                <span class="badge bg-dark rounded-pill">
                                    <i class="bi bi-people"></i> {{ $booking->guests_count }}
                                </span>
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                        <i class="bi bi-clock-history"></i> Ожидает
                                    </span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-dark px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle"></i> Подтверждено
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle"></i> Отменено
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto; display: inline-block;">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Ожидает</option>
                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                                        </select>
                                    </form>
                                    <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#bookingDetails{{ $booking->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <div class="modal fade" id="bookingDetails{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title">
                                            <i class="bi bi-info-circle"></i> Детали бронирования #{{ $booking->id }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body bg-white">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="info-card p-3 bg-light rounded">
                                                    <small class="text-muted">Клиент</small>
                                                    <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                                    <small class="text-secondary">{{ $booking->user->email }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card p-3 bg-light rounded">
                                                    <small class="text-muted">Столик</small>
                                                    <div class="fw-bold text-dark">{{ $booking->table->name }}</div>
                                                    <small class="text-secondary">{{ $booking->table->seats }} места</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="info-card p-3 bg-light rounded">
                                                    <small class="text-muted">Дата и время</small>
                                                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</div>
                                                    <div class="text-secondary">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card p-3 bg-light rounded">
                                                    <small class="text-muted">Гостей</small>
                                                    <div class="fw-bold text-dark">{{ $booking->guests_count }} человек</div>
                                                    <span class="badge {{ $booking->status == 'pending' ? 'bg-secondary' : ($booking->status == 'confirmed' ? 'bg-dark' : 'bg-light text-dark border') }}">
                                                        {{ $booking->status == 'pending' ? 'Ожидает' : ($booking->status == 'confirmed' ? 'Подтверждено' : 'Отменено') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($booking->special_requests)
                                        <div class="mb-3">
                                            <div class="info-card p-3 bg-light rounded">
                                                <small class="text-muted">Особые пожелания</small>
                                                <div class="mt-1 text-dark">{{ $booking->special_requests }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($booking->menuItems->count() > 0)
                                        <div class="mb-3">
                                            <div class="info-card p-3 bg-light rounded">
                                                <small class="text-muted">Заказанные блюда</small>
                                                <ul class="list-unstyled mt-2 mb-0">
                                                    @foreach($booking->menuItems as $item)
                                                        <li class="mb-1 text-dark">
                                                            <i class="bi bi-cup-straw"></i> {{ $item->name }} 
                                                            <span class="text-secondary">x{{ $item->pivot->quantity }}</span>
                                                            <span class="float-end">{{ number_format($item->price * $item->pivot->quantity, 2) }} руб.</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <hr class="my-2">
                                                <div class="fw-bold text-dark">
                                                    Итого: {{ number_format($booking->total_price, 2) }} руб.
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-black-50"></i>
                                <p class="text-secondary mt-2">Нет бронирований с выбранным статусом</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.booking-row:hover {
    background-color: #f8f9fa;
}
.info-card {
    border: 1px solid #dee2e6;
}
.avatar-sm {
    width: 32px;
    height: 32px;
}
.btn-outline-dark {
    border: 1px solid #000000;
    color: #000000;
}
.btn-outline-dark:hover {
    background: #000000;
    color: #ffffff;
}
.btn-dark {
    background: #000000;
    border: 1px solid #000000;
}
.btn-dark:hover {
    background: #333333;
    border-color: #333333;
}
.btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
}
.btn-outline-secondary:hover {
    background: #6c757d;
    color: #ffffff;
}
.btn-secondary {
    background: #6c757d;
    border: 1px solid #6c757d;
}
.table-dark {
    background-color: #000000 !important;
}
.bg-dark {
    background-color: #000000 !important;
}
.text-black-50 {
    color: rgba(0,0,0,0.5) !important;
}


.table thead th {
    background: black;
}

</style>
@endsection