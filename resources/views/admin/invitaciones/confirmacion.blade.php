@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Confirmar Asistencia</h2>
    <p><strong>Invitación de:</strong> {{ $invitacion->nombre }}</p>
    <p><strong>Evento:</strong> {{ $invitacion->evento->nombre }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($invitacion->confirmado)
        <div class="alert alert-info">Esta invitación ya fue confirmada. Gracias por confirmar tu asistencia.</div>
    @endif

    <form method="POST" action="{{ route('invitacion.confirmar', $invitacion->tokenid) }}">
        @csrf

        <h5>Invitados:</h5>
        <ul class="list-group mb-3">
            @foreach($invitacion->invitados as $invitado)
                <li class="list-group-item">
                    @if($invitado->confirmado)
                        <strong>{{ $invitado->nombre }}</strong>
                        <span class="badge bg-success ms-2">Confirmado</span>
                    @else
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="confirmados[]" value="{{ $invitado->id }}">
                            <label class="form-check-label">
                                @if($invitado->es_ancla)
                                    {{ $invitado->nombre }}
                                @else
                                    <input type="text" name="nombres[{{ $invitado->id }}]" class="form-control d-inline-block w-auto" value="{{ $invitado->nombre }}">
                                @endif
                            </label>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        @unless($invitacion->confirmado)
            <button type="submit" class="btn btn-primary">Guardar Confirmación</button>
        @endunless
    </form>
</div>
@endsection

