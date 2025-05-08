@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Confirmación de asistencia</h4>
    <p>Ingresa tu contraseña para continuar</p>

    <form action="{{ route('confirmacion.store', $invitacion->tokenid) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="password">Contraseña:</label>
            <input type="text" name="password" class="form-control" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button class="btn btn-primary">Acceder</button>
    </form>
</div>
@endsection
