<p>Hola {{ $invitacion->nombre }},</p>
<p>Te invitamos a confirmar tu asistencia al evento <strong>{{ $invitacion->evento->nombre }}</strong>.</p>
<p>Tu enlace es: <a href="{{ route('invitacion.publica', $invitacion->tokenid) }}">{{ route('invitacion.publica', $invitacion->tokenid) }}</a></p>
<p>Contraseña: <strong>{{ $invitacion->password }}</strong></p>
