@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Crear NIS</h2>

    <!-- Botón para volver a la lista de NIS -->
    <a href="{{ route('admin.nis.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Volver a la lista de NIS
    </a>

    <form action="{{ route('admin.nis.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" name="descripcion" required>
        </div>

        <div class="form-group mb-3">
            <label for="numero_piso">Número de Piso</label>
            <input type="number" class="form-control" name="numero_piso" required>
        </div>

        <div class="form-group mb-3">
            <label for="numero_mesa">Número de Mesa</label>
            <input type="number" class="form-control" name="numero_mesa" required>
        </div>

        <div class="form-group mb-3">
            <label for="menu_id">Menú</label>
            <select name="menu_id" class="form-control" required>
                @foreach($menus as $menu)
                    <option value="{{ $menu->idMenu }}">{{ $menu->Descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="eventos_id">Evento (Opcional)</label>
            <select name="eventos_id" class="form-control">
                <option value="">Seleccionar Evento (Opcional)</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->idEventos }}">{{ $evento->Titulo }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Crear NIS</button>
    </form>
</div>
@endsection
