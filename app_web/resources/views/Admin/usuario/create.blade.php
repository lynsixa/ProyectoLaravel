@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Crear Usuario</h2>

    <!-- Mostrar errores de validación -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario para crear un nuevo usuario -->
    <form action="{{ route('admin.usuario.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="Nombres">Nombres</label>
            <input type="text" class="form-control" name="Nombres" value="{{ old('Nombres') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="Apellidos">Apellidos</label>
            <input type="text" class="form-control" name="Apellidos" value="{{ old('Apellidos') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="Documento">Documento</label>
            <input type="text" class="form-control" name="Documento" value="{{ old('Documento') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="Correo">Correo</label>
            <input type="email" class="form-control" name="Correo" value="{{ old('Correo') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="Contraseña">Contraseña</label>
            <input type="password" class="form-control" name="Contraseña" required>
        </div>

        <div class="form-group mb-3">
            <label for="Contraseña_confirmation">Confirmar Contraseña</label>
            <input type="password" class="form-control" name="Contraseña_confirmation" required>
        </div>

        <div class="form-group mb-3">
            <label for="FechaDeNacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="FechaDeNacimiento" value="{{ old('FechaDeNacimiento') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="Tipo_de_documento_idTipodedocumento">Tipo de Documento</label>
            <select name="Tipo_de_documento_idTipodedocumento" class="form-control" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->idTipodedocumento }}" {{ old('Tipo_de_documento_idTipodedocumento') == $tipo->idTipodedocumento ? 'selected' : '' }}>
                        {{ $tipo->Descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="Roles_idRoles">Rol</label>
            <select name="Roles_idRoles" class="form-control" required>
                @foreach($roles as $rol)
                    <option value="{{ $rol->idRoles }}" {{ old('Roles_idRoles') == $rol->idRoles ? 'selected' : '' }}>
                        {{ $rol->Descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Crear Usuario</button>
    </form>

    <!-- Botón para volver a NIS -->
    <a href="{{ route('admin.usuario.index') }}" class="btn btn-secondary mt-3">
        Volver a usuarios
    </a>
</div>
@endsection
