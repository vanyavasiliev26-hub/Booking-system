@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Забронировать столик</div>
                
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Дата</label>
                            <input type="date" class="form-control @error('booking_date') is-invalid @enderror" 
                                   id="booking_date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required>
                            @error('booking_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="booking_time" class="form-label">Время</label>
                            <select class="form-control @error('booking_time') is-invalid @enderror" 
                                    id="booking_time" name="booking_time" required>
                                <option value="">Выберите время</option>
                                @foreach($times as $time)
                                    <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                            @error('booking_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="guests_count" class="form-label">Количество гостей</label>
                            <input type="number" class="form-control @error('guests_count') is-invalid @enderror" 
                                   id="guests_count" name="guests_count" value="{{ old('guests_count', 2) }}" min="1" max="20" required>
                            @error('guests_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="table_id" class="form-label">Столик</label>
                            <select class="form-control @error('table_id') is-invalid @enderror" 
                                    id="table_id" name="table_id" required>
                                <option value="">Выберите столик</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                        {{ $table->name }} ({{ $table->seats }} мест)
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Заказ из меню</label>
                            <div class="row">
                                @foreach($menuItems->groupBy('category') as $category => $items)
                                    <div class="col-md-6">
                                        <strong>{{ ucfirst($category) }}</strong>
                                        @foreach($items as $item)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="menu_items[]" value="{{ $item->id }}"
                                                       id="item_{{ $item->id }}">
                                                <label class="form-check-label" for="item_{{ $item->id }}">
                                                    {{ $item->name }} - {{ $item->price }} руб.
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Особые пожелания</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" 
                                      rows="3">{{ old('special_requests') }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Забронировать</button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection