@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('admin.eventos.index') }}" class="btn btn-dark mb-4">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>

    <div class="card">
        <div class="card-body">
            <h2 class="mb-4 text-primary">Editar Evento</h2>
            <form method="POST" action="{{ route('admin.eventos.update', $evento->idEventos) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" value="{{ $evento->Titulo }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" required>{{ $evento->Descripcion }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_evento" class="form-label">Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" name="fecha_evento" id="fecha_evento" value="{{ \Carbon\Carbon::parse($evento->Fecha_Evento)->format('Y-m-d\TH:i') }}" required>
                </div>

                <button type="submit" class="btn btn-warning">Actualizar Evento</button>
            </form>
        </div>
    </div>
</div>
@endsection
