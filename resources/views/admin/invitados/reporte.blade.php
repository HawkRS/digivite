<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Invitados</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Lista de Invitados - {{ ucfirst($filtro) }}</h3>
    <table>
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
            @foreach($invitados as $invitado)
                <tr>
                    <td>{{ $invitado->nombre }}</td>
                    <td>{{ $invitado->confirmado ? 'Sí' : 'No' }}</td>
                    <td>{{ $invitado->invitacion->nombre }}</td>
                    <td>{{ $invitado->invitacion->invitadoancla }}</td>
                    <td>{{ $invitado->invitacion->evento->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
