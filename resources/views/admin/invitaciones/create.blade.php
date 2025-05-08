@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Invitación</h2>
    <form action="{{ route('invitaciones.store') }}" method="POST">
        @csrf
        <input type="hidden" name="evento_id" value="{{$evento->id}}">
        {{--
        <div class="mb-3">
            <label class="form-label">Evento</label>
            <select name="evento_id" class="form-control" required>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        --}}
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Invitado Ancla</label>
            <input type="text" name="invitado_ancla" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Comentario</label>
            <textarea name="comentario" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <h4>Invitados</h4>
        <div id="invitados">
            <div class="mb-3 invitado d-flex align-items-center">
                <input type="text" name="invitados[]" class="form-control mb-2 me-2" placeholder="Nombre del invitado">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarInvitado(this)">✕</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" onclick="agregarInvitado()">Agregar otro invitado</button>



        <button type="submit" class="btn btn-primary">Guardar Invitación</button>
    </form>
</div>

<script>
    function agregarInvitado() {
        const contenedor = document.getElementById('invitados');
        const div = document.createElement('div');
        div.className = 'mb-3 invitado d-flex align-items-center';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'invitados[]';
        input.placeholder = 'Nombre del invitado';
        input.className = 'form-control mb-2 me-2';

        const boton = document.createElement('button');
        boton.type = 'button';
        boton.className = 'btn btn-danger btn-sm';
        boton.innerText = '✕';
        boton.onclick = function () {
            eliminarInvitado(boton);
        };

        div.appendChild(input);
        div.appendChild(boton);
        contenedor.appendChild(div);
    }

    function eliminarInvitado(boton) {
        const div = boton.parentNode;
        div.remove();
    }
</script>

@endsection