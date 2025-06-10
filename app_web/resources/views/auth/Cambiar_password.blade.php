<!-- resources/views/auth/cambiar_password.blade.php -->
@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cambiar contraseña') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('recuperar.cambiar.enviar') }}">
                        @csrf

                        <!-- Campos ocultos para el ID y el token -->
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nueva Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cambiar Contraseña') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
      background: linear-gradient(135deg, #fff176, #000000);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(255, 235, 59, 0.5);
      max-width: 450px;
      width: 100%;
      color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 1.8rem;
      color: #ffeb3b;
    }

    .form-label {
      color: #ffeb3b;
    }

    .form-control {
      border-radius: 12px;
    }

    .btn-warning {
      width: 100%;
      border-radius: 12px;
    }

    .input-group-text {
      background-color: #ffc107;
      color: #000;
      border: none;
      border-radius: 12px 0 0 12px;
    }

    .input-group .form-control {
      border-radius: 0 12px 12px 0;
    }
  </style>
@endpush
@endsection
