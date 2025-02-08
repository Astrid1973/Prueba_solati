@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Tareas</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        <span class="badge {{ $task->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $task->status ? 'Completada' : 'Pendiente' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm {{ $task->status ? 'btn-warning' : 'btn-success' }}">
                                {{ $task->status ? 'Marcar como Pendiente' : 'Marcar como Completada' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar tarea?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No tienes tareas registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Nueva Tarea</a>
</div>
@endsection