@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white border-0">
                    <h5 class="mb-0 fw-bold">РЕГИСТРАЦИЯ</h5>
                </div>
                <div class="card-body bg-white">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-semibold">ИМЯ</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark fw-semibold">EMAIL АДРЕС</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark fw-semibold">ПАРОЛЬ</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-dark fw-semibold">ПОДТВЕРЖДЕНИЕ ПАРОЛЯ</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark py-2">
                                <i class="bi bi-person-plus"></i> ЗАРЕГИСТРИРОВАТЬСЯ
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-link text-decoration-none">
                                Уже есть аккаунт? Войдите
                            </a>
                        </div>
                    </form>
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
.form-control {
    border: 1px solid #dee2e6;
    border-radius: 0;
    padding: 10px 15px;
}
.form-control:focus {
    border-color: #000000;
    box-shadow: none;
}
.btn-dark {
    background: #000000;
    border: 1px solid #000000;
}
.btn-dark:hover {
    background: #333333;
    border-color: #333333;
}
.text-link {
    color: #000000;
    transition: opacity 0.3s ease;
}
.text-link:hover {
    color: #666666;
    text-decoration: underline;
}
.invalid-feedback {
    color: #dc3545;
    font-size: 0.8rem;
}
</style>
@endsection