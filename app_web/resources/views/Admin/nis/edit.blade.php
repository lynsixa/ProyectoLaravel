@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Editar NIS</h2>

    <!-- Mensaje de error si existe -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Botón para volver a la lista de NIS -->
    <a href="{{ route('admin.nis.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left-circle"></i> Volver a la lista de NIS
    </a>

    <form action="{{ route('admin.nis.update', $nis->idCodigoNis) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" name="descripcion" value="{{ $nis->Descripcion }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="numero_piso">Número de Piso</label>
            <input type="number" class="form-control" name="numero_piso" value="{{ $nis->Mesa->NumeroPiso }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="menu_id">Menú</label>
            <select name="menu_id" class="form-control" required>
                @foreach($menus as $menu)
                    <option value="{{ $menu->idMenu }}" {{ $nis->Menu_idMenu == $menu->idMenu ? 'selected' : '' }}>{{ $menu->Descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="eventos_id">Evento (Opcional)</label>
            <select name="eventos_id" class="form-control">
                <option value="">Seleccionar Evento (Opcional)</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->idEventos }}" {{ $nis->Eventos_idEventos == $evento->idEventos ? 'selected' : '' }}>{{ $evento->Titulo }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="disponibilidad">Disponibilidad</label>
            <select name="disponibilidad" class="form-control" required>
                <option value="1" {{ $nis->Disponibilidad == 1 ? 'selected' : '' }}>Disponible</option>
                <option value="0" {{ $nis->Disponibilidad == 0 ? 'selected' : '' }}>No Disponible</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar NIS</button>
    </form>
</div>
@endsection
