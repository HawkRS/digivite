<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Digivite</title>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <p>{{$evento->tipo}} de {{$evento->nombre}}</p>
          <p>{{$evento->fecha}}</p>
          <p>{{$evento->horario}}</p>
          <p>{{$evento->ubicacion}}</p>
        </div>
      </div>
    </div>
    <img src="{{ asset('storage/qrs/' . $evento->id . '.svg') }}" alt="Código QR">

  </body>
</html>