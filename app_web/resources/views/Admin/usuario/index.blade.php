@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Lista de Usuarios</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Botón para volver al índice del administrador -->
    <a href="{{ route('admin.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left-circle"></i> Volver al índice
    </a> </br>

    <a href="{{ route('admin.usuario.create') }}" class="btn btn-primary mb-4">Crear Nuevo Usuario</a>

    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Documento</th>
                <th>Correo</th>
                <th>Tipo de Documento</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->idUsuario }}</td>
                    <td>{{ $usuario->Nombres }}</td>
                    <td>{{ $usuario->Apellidos }}</td>
                    <td>{{ $usuario->Documento }}</td>
                    <td>{{ $usuario->Correo }}</td>
                    <td>{{ $usuario->tipoDeDocumento ? $usuario->tipoDeDocumento->Descripcion : 'N/A' }}</td>
                    <td>{{ $usuario->roles ? $usuario->roles->Descripcion : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.usuario.edit', $usuario->idUsuario) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.usuario.destroy', $usuario->idUsuario) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
