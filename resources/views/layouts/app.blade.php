<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Poppins:300,400,500,600" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            color: #333333;
        }
        
        .navbar {
            background: #000000 !important;
            border-bottom: 1px solid #333333;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff !important;
        }
        
        .nav-link {
            color: #ffffff !important;
            font-weight: 400;
            font-size: 0.9rem;
        }
        
        .nav-link:hover {
            color: #cccccc !important;
        }
        
        .dropdown-menu {
            background: #000000;
            border: 1px solid #333333;
        }
        
        .dropdown-item {
            color: #ffffff;
        }
        
        .dropdown-item:hover {
            background: #333333;
            color: #ffffff;
        }
        
        /* Черные кнопки - без анимации */
        .btn-black {
            background-color: #000000;
            border: 1px solid #000000;
            color: #ffffff;
            padding: 10px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-black:hover {
            background-color: #333333;
            border-color: #333333;
            color: #ffffff;
        }
        
        .btn-outline-black {
            background-color: transparent;
            border: 1px solid #000000;
            color: #000000;
            padding: 10px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-outline-black:hover {
            background-color: #000000;
            color: #ffffff;
        }
        
        .btn-lg {
            padding: 12px 35px;
            font-size: 1rem;
        }
        
        /* Карточки - без подскакивания */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Заголовки */
        .display-4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #000000;
        }
        
        .lead {
            color: #666666;
        }
        
        /* Формы */
        .form-control {
            border-radius: 0;
            border: 1px solid #dddddd;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: #000000;
            box-shadow: none;
        }
        
        .form-label {
            font-weight: 500;
            color: #333333;
        }
        
        /* Кнопки в формах */
        .btn-primary {
            background-color: #000000;
            border-color: #000000;
            border-radius: 0;
            padding: 10px 25px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #333333;
            border-color: #333333;
        }
        
        
        .table {
            background: #ffffff;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        
        
        .badge {
            padding: 5px 10px;
            font-weight: 500;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        
        .badge-success {
            background-color: #28a745;
            color: #fff;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }
        
        
        footer {
            background: #000000;
            color: #ffffff;
            padding: 30px 0;
            margin-top: 50px;
        }
        
        
        .btn-link {
            color: #ffffff;
            text-decoration: none;
        }
        
        .btn-link:hover {
            color: #cccccc;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .btn-black, .btn-outline-black {
                padding: 8px 20px;
                font-size: 0.8rem;
            }
            
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    RESTAURANT
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('bookings.index') }}">
                                    <i class="bi bi-calendar-check"></i> МОИ БРОНИРОВАНИЯ
                                </a>
                            </li>
                            @if(Auth::user()->isAdmin())
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-shield-lock"></i> АДМИН ПАНЕЛЬ
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.tables') }}">
                                            <i class="bi bi-grid"></i> Столики
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.menu') }}">
                                            <i class="bi bi-menu-button-wide"></i> Меню
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.bookings') }}">
                                            <i class="bi bi-list-check"></i> Бронирования
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> ВХОД
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i> РЕГИСТРАЦИЯ
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="bi bi-person"></i> Профиль
                                    </a>
                                    <a class="dropdown-item" href="{{ route('bookings.index') }}">
                                        <i class="bi bi-calendar"></i> Бронирования
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Выйти
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>