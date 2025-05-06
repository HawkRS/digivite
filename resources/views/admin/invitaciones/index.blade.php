@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Invitaciones</h2>
    <a href="{{ route('invitaciones.create') }}">Crear nueva invitación</a>

    @php
        $totalBoletos = $invitaciones->sum('boletos');
        $confirmadas = $invitaciones->where('confirmado', true)->sum('boletos');
        $pendientes = $totalBoletos - $confirmadas;
    @endphp

    <div class="mb-3">
        <strong>Total invitados:</strong> {{ $totalBoletos }} |
        <strong>Confirmados:</strong> {{ $confirmadas }} |
        <strong>Por confirmar:</strong> {{ $pendientes }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Evento</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Boletos</th>
                <th>Confirmado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invitaciones as $inv)
                <tr>
                    <td>{{ $inv->nombre }}</td>
                    <td>{{ $inv->evento->nombre }}</td>
                    <td>{{ $inv->correo }}</td>
                    <td>{{ $inv->telefono }}</td>
                    <td>{{ $inv->boletos }}</td>
                    <td>
                        @if($inv->confirmado)
                            <span class="badge bg-success">Sí</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                      <a href="{{route('invitacion.publica', ['tokenid'=>$inv->tokenid]) }}">Confirmacion</a>
                        <a href="{{ route('invitaciones.edit', $inv->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('invitaciones.destroy', $inv->id) }}" method="POST" class="d-inline">
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
