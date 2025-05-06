@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Confirmar Asistencia</h2>
    <p><strong>Invitación de:</strong> {{ $invitacion->nombre }}</p>
    <p><strong>Evento:</strong> {{ $invitacion->evento->nombre }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('invitacion.confirmar', $invitacion->tokenid) }}">
        @csrf

        <h5>Selecciona a los invitados que asistirán:</h5>
        <ul class="list-group mb-3">
            @foreach($invitacion->invitados as $invitado)
                <li class="list-group-item">
                    <label>
                        <input type="checkbox" name="confirmados[]" value="{{ $invitado->id }}"
                            {{ $invitado->confirmado ? 'checked disabled' : '' }}>
                        {{ $invitado->nombre }}
                        @if($invitado->confirmado)
                            <span class="badge bg-success">Confirmado</span>
                        @endif
                    </label>
                </li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary">Guardar Confirmación</button>
    </form>
</div>
@endsection
