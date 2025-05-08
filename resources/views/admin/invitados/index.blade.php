@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Control de Acceso de Invitados</h2>

    <div class="mb-3">
        <a href="{{ route('invitados.index', ['filtro' => 'todos']) }}" class="btn btn-outline-primary {{ $filtro == 'todos' ? 'active' : '' }}">Todos</a>
        <a href="{{ route('invitados.index', ['filtro' => 'confirmados']) }}" class="btn btn-outline-success {{ $filtro == 'confirmados' ? 'active' : '' }}">Confirmados</a>
        <a href="{{ route('invitados.index', ['filtro' => 'no_confirmados']) }}" class="btn btn-outline-danger {{ $filtro == 'no_confirmados' ? 'active' : '' }}">No Confirmados</a>
        <a href="{{ route('invitados.exportar', ['filtro' => $filtro]) }}" class="btn btn-dark float-end">
            Exportar a PDF
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Invitado</th>
                <th>Confirmado</th>
                <th>Invitación</th>
                <th>Invitado Ancla</th>
                <th>Evento</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invitados as $invitado)
                <tr>
                    <td>{{ $invitado->nombre }}</td>
                    <td>
                        @if($invitado->confirmado)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>{{ $invitado->invitacion->nombre }}</td>
                    <td>{{ $invitado->invitacion->invitadoancla }}</td>
                    <td>{{ $invitado->invitacion->evento->nombre }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay invitados en esta categoría</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
