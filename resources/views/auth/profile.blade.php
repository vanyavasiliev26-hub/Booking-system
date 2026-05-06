@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white border-0">
                    <h5 class="mb-0 fw-bold">МОЙ ПРОФИЛЬ</h5>
                </div>
                <div class="card-body bg-white">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Имя</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2">{{ $user->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Email адрес</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2">{{ $user->email }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Телефон</label>
                        <p class="form-control-plaintext text-dark border-bottom pb-2">{{ $user->phone ?: 'Не указан' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Роль</label>
                        <p class="form-control-plaintext">
                            @if($user->role === 'admin')
                                <span class="badge bg-dark">АДМИНИСТРАТОР</span>
                            @else
                                <span class="badge bg-secondary">ПОЛЬЗОВАТЕЛЬ</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Дата регистрации</label>
                        <p class="form-control-plaintext text-secondary">{{ $user->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
.btn-close {
    filter: invert(0);
}
</style>
@endsection