@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Generar Informes</h2>

    <div class="text-center">
        <a href="{{ route('gerente.informes.usuarios') }}" class="btn btn-primary mb-3">📥 Descargar Informe de Usuarios</a>
        <br>
        <a href="{{ route('gerente.informes.ordenes') }}" class="btn btn-primary mb-3">📥 Descargar Informe de Órdenes</a>
        <br>
        <a href="{{ route('gerente.informes.todos') }}" class="btn btn-primary mb-3">📦 Descargar Todos los Informes</a>
    </div>
</div>
@endsection
