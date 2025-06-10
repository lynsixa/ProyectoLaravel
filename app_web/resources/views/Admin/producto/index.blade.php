@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Lista de Productos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para volver a la página de administración -->
    <a href="{{ url('/admin') }}" class="btn btn-secondary mb-4">← Volver a la administración</a>

    <a href="{{ route('admin.producto.create') }}" class="btn btn-primary mb-4">Crear Nuevo Producto</a>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Disponibilidad</th>
                <th>Foto 1</th>
                <th>Foto 2</th>
                <th>Foto 3</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                @php
                    $categoria = $producto->categoria;
                @endphp
                <tr>
                    <td>{{ $producto->idProducto }}</td>
                    <td>{{ $categoria?->Nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $categoria?->Descripcion ?? '---' }}</td>
                    <td>{{ $producto->Precio }}</td>
                    <td>{{ $producto->Cantidad }}</td>
                    <td>{{ $producto->Cantidad > 0 ? 'Disponible' : 'No Disponible' }}</td>

                    <td>
                        @if($categoria && $categoria->Foto1 && file_exists(public_path('fotosProductos/' . $categoria->Foto1)))
                            <img src="{{ asset('fotosProductos/' . $categoria->Foto1) }}" width="80">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>
                    <td>
                        @if($categoria && $categoria->Foto2 && file_exists(public_path('fotosProductos/' . $categoria->Foto2)))
                            <img src="{{ asset('fotosProductos/' . $categoria->Foto2) }}" width="80">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>
                    <td>
                        @if($categoria && $categoria->Foto3 && file_exists(public_path('fotosProductos/' . $categoria->Foto3)))
                            <img src="{{ asset('fotosProductos/' . $categoria->Foto3) }}" width="80">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.producto.edit', $producto->idProducto) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('admin.producto.destroy', $producto->idProducto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
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
