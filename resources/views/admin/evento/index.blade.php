@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <p>{{$evento->tipo}} de {{$evento->nombre}}</p>
          <p>{{$evento->fecha}}</p>
          <p>{{$evento->horario}}</p>
          <p>{{$evento->ubicacion}}</p>
    <img src="{{ asset('storage/qrs/' . $evento->id . '.svg') }}" alt="Código QR">
        </div>
        <div class="col-md-6">

        </div>
      </div>
    </div>
@endsection