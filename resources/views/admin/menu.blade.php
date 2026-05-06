@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Добавить блюдо</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.menu.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Цена (руб.)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category" class="form-control">
                                <option value="appetizer">Закуски</option>
                                <option value="soup">Супы</option>
                                <option value="main">Основные блюда</option>
                                <option value="dessert">Десерты</option>
                                <option value="drink">Напитки</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Меню</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menuItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ Str::limit($item->description, 50) }}</td>
                                <td>{{ number_format($item->price, 2) }} руб.</td>
                                <td>{{ $item->category }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editItem{{ $item->id }}">Ред.</button>
                                    <form action="{{ route('admin.menu.delete', $item) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                            
                            
                            <div class="modal fade" id="editItem{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.menu.update', $item) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5>Редактировать блюдо</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Название</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Описание</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $item->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Цена</label>
                                                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $item->price }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Категория</label>
                                                    <select name="category" class="form-control">
                                                        <option value="appetizer" {{ $item->category == 'appetizer' ? 'selected' : '' }}>Закуски</option>
                                                        <option value="soup" {{ $item->category == 'soup' ? 'selected' : '' }}>Супы</option>
                                                        <option value="main" {{ $item->category == 'main' ? 'selected' : '' }}>Основные</option>
                                                        <option value="dessert" {{ $item->category == 'dessert' ? 'selected' : '' }}>Десерты</option>
                                                        <option value="drink" {{ $item->category == 'drink' ? 'selected' : '' }}>Напитки</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Доступно</label>
                                                    <select name="is_available" class="form-control">
                                                        <option value="1" {{ $item->is_available ? 'selected' : '' }}>Да</option>
                                                        <option value="0" {{ !$item->is_available ? 'selected' : '' }}>Нет</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection