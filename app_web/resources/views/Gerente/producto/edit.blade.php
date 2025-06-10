@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Editar Producto</h2>
    <form action="{{ route('gerente.producto.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">  <!-- Cambiado a la ruta gerente -->
        @csrf
        @method('PUT')
        <div>
            <label>Precio</label>
            <input type="text" name="precio" value="{{ $producto->Precio }}" required>
        </div>
        <div>
            <label>Cantidad</label>
            <input type="number" name="cantidad" value="{{ $producto->Cantidad }}" required>
        </div>
        <div>
            <label>Nombre de Categoría</label>
            <input type="text" name="nombre_categoria" value="{{ $producto->categoria->Nombre }}" required>
        </div>
        <div>
            <label>Descripción</label>
            <textarea name="descripcion" required>{{ $producto->categoria->Descripcion }}</textarea>
        </div>
        <div>
            <label>Imagen 1</label>
            <input type="file" name="imagen1">
            <br>
            <img src="{{ asset('fotosProductos/' . $producto->categoria->Foto1) }}" width="100">
        </div>
        <div>
            <label>Imagen 2</label>
            <input type="file" name="imagen2">
            @if($producto->categoria->Foto2)
                <br>
                <img src="{{ asset('fotosProductos/' . $producto->categoria->Foto2) }}" width="100">
            @endif
        </div>
        <div>
            <label>Imagen 3</label>
            <input type="file" name="imagen3">
            @if($producto->categoria->Foto3)
                <br>
                <img src="{{ asset('fotosProductos/' . $producto->categoria->Foto3) }}" width="100">
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
    </form>
</div>
@endsection
