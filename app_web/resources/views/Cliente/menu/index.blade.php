@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Menú</h1>

    <div class="row">
        @foreach($productos as $producto)
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('fotosProductos/' . $producto->categoria->Foto1) }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->categoria->Nombre }}</h5>
                    <p>{{ $producto->categoria->Descripcion }}</p>
                    <p><strong>${{ $producto->Precio }}</strong></p>
                    <form method="POST" action="{{ route('menu.agregar') }}">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->idProducto }}">
                        <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2">
                        <button class="btn btn-primary">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2>Carrito de Compras</h2>
    @if($carrito->isEmpty())
        <p>El carrito está vacío.</p>
    @else
        <ul>
            @foreach($carrito as $item)
                <li>{{ $item->categoria->Nombre }} x {{ $item->cantidad }}
                    <form action="{{ route('menu.eliminar', $item->idProducto) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <form action="{{ route('menu.vaciar') }}" method="POST" class="mb-2">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">Vaciar carrito</button>
        </form>

        <form action="{{ route('orden.guardar.desdeCarrito') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Generar Orden</button>
        </form>
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
