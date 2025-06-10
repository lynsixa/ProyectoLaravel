@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Crear Producto</h2>

    <!-- Botón para volver al listado -->
    <a href="{{ route('admin.producto.index') }}" class="btn btn-secondary mb-4">← Volver a la lista de productos</a>

    <form action="{{ route('admin.producto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" max="9999999.999" step="0.001" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nombre de Categoría</label>
            <input type="text" name="nombre_categoria" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Imagen 1</label>
            <input type="file" name="imagen1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Imagen 2</label>
            <input type="file" name="imagen2" class="form-control">
        </div>

        <div class="mb-3">
            <label>Imagen 3</label>
            <input type="file" name="imagen3" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Crear</button>
    </form>
</div>
@endsection
