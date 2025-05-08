<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar py-4">
  <div class="position-sticky">
    <h4 class="text-center mb-4">Menú</h4>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa-solid fa-calendar-check"></i> Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('eventos.index') }}"><i class="fa-solid fa-calendar-check"></i> Evento</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('eventos.create') }}"><i class="fa-solid fa-calendar-check"></i> crear Evento</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('invitaciones.index') }}"><i class="fa-solid fa-receipt"></i> lista de invitaciones</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('invitaciones.create') }}"><i class="fa-solid fa-receipt"></i> Crear invitacion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('invitados.index') }}"><i class="fa-solid fa-users"></i> Lista de invitados</a>
      </li>
      <li class="nav-item mt-4">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-danger w-100">Salir</button>
        </form>
      </li>
    </ul>
  </div>
</nav>