@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Добавить столик</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tables.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Количество мест</label>
                            <input type="number" name="seats" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Список столиков</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Мест</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tables as $table)
                            <tr>
                                <td>{{ $table->name }}</td>
                                <td>{{ $table->seats }}</td>
                                <td>
                                    <span class="badge bg-{{ $table->is_active ? 'success' : 'danger' }}">
                                        {{ $table->is_active ? 'Активен' : 'Неактивен' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editTable{{ $table->id }}">Редактировать</button>
                                    <form action="{{ route('admin.tables.delete', $table) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                            
                            
                            <div class="modal fade" id="editTable{{ $table->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.tables.update', $table) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5>Редактировать столик</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Название</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $table->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Количество мест</label>
                                                    <input type="number" name="seats" class="form-control" value="{{ $table->seats }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Статус</label>
                                                    <select name="is_active" class="form-control">
                                                        <option value="1" {{ $table->is_active ? 'selected' : '' }}>Активен</option>
                                                        <option value="0" {{ !$table->is_active ? 'selected' : '' }}>Неактивен</option>
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