@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Evento</h2>
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-control" required>
                <option value="boda">Boda</option>
                <option value="compromiso">Compromiso</option>
                <option value="cumpleaños">Cumpleaños</option>
                <option value="bautizo">Bautizo</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Horario</label>
            <input type="time" name="horario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Evento</button>
    </form>
</div>
@endsection