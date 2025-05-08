<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invitacion;
use App\Models\Invitados;
use App\Models\Evento;
use Carbon\Carbon;

class InvitacionController extends Controller
{
  private $f = 'admin.invitaciones.';

  public function __construct()
  {
    $this->middleware('auth')->except(['confirmarPublica','mostrarLogin','verificarPassword','guardarConfirmacion']);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $invitaciones = Invitacion::with('evento')->latest()->get();
    //dd($invitaciones);
    return view($this->f.'index', compact('invitaciones'));
  }


  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $evento = Evento::first();
    return view($this->f.'create', [
      'evento' =>$evento
    ]);
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //dd($request->all());
    $validated = $request->validate([
    'evento_id' => 'required|exists:eventos,id',
    'nombre' => 'required|string|max:255', // nombre de la invitación
    'comentario' => 'nullable|string',
    'correo' => 'nullable|email',
    'telefono' => 'nullable|string|max:20',
    'invitadoancla' => 'required|string|max:255',
    'invitados' => 'nullable|array',
    'invitados.*' => 'nullable|string|max:255',
    ]);


    $validated['tokenid'] = Str::random(8); // token sencillo
    $validated['password'] = Str::random(8); // contraseña segura y corta
    //dd($validated['password']);


    // Crear la invitación
    $invitacion = Invitacion::create($validated);

    // Crear invitado ancla
    $invitacion->invitados()->create([
    'nombre' => $validated['invitadoancla'],
    'confirmado' => false,
    'es_ancla' => true,
    ]);

    $numboletos = 1; // ya se cuenta el ancla

    // Crear acompañantes
    if (!empty($request->invitados)) {
      foreach ($request->invitados as $nombreInvitado) {
        if (trim($nombreInvitado) !== '') {
          $numboletos += 1;
          $invitacion->invitados()->create([
          'nombre' => $nombreInvitado,
          'confirmado' => false,
          'es_ancla' => false,
          ]);
        }
      }
    }

    $invitacion->boletos = $numboletos;
    $invitacion->save();

    return redirect()->route('invitaciones.index')->with('success', 'Invitación creada correctamente');

  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }

  public function confirmarPublica($tokenid)
  {
    $invitacion = Invitacion::where('tokenid', $tokenid)->with('invitados')->firstOrFail();
    return view($this->f.'confirmacion', compact('invitacion'));
  }

  public function mostrarLogin($tokenid)
  {
    $invitacion = Invitacion::where('tokenid', $tokenid)->firstOrFail();
    return view($this->f.'confirmar_login', compact('invitacion'));
  }

  public function verificarPassword(Request $request, $tokenid)
  {
    $request->validate(['password' => 'required']);

    $invitacion = Invitacion::where('tokenid', $tokenid)->firstOrFail();

    if ($request->password === $invitacion->password) {
      session()->put("invitacion_autorizada_{$tokenid}", true);
      return redirect()->route('invitacion.publica', $tokenid);
    }

    return back()->withErrors(['password' => 'Contraseña incorrecta']);
  }

  public function guardarConfirmacion(Request $request, $tokenid)
  {
    $invitacion = Invitacion::where('tokenid', $tokenid)->with('invitados')->firstOrFail();
    $confirmados = $request->input('confirmados', []);
    $nombres = $request->input('nombres', []);

    $numboletos = 0;

    foreach ($invitacion->invitados as $invitado) {
      // Actualiza nombre si no es ancla, no está confirmado y hay nombre nuevo
      if (!$invitado->es_ancla && !$invitado->confirmado && isset($nombres[$invitado->id])) {
        $nuevoNombre = trim($nombres[$invitado->id]);
        if ($nuevoNombre !== '') {
          $invitado->nombre = $nuevoNombre;
        }
      }

      // Confirmar asistencia si fue marcado
      if (!$invitado->confirmado && in_array($invitado->id, $confirmados)) {
        $invitado->confirmado = true;
        $numboletos += 1;
      }

      $invitado->save();
    }

    $invitacion->boletos = $numboletos;
    $invitacion->confirmado = true;
    $invitacion->save();

    return redirect()->back()->with('success', '¡Confirmación guardada correctamente!');
  }


  public function enviarCorreo($id)
  {
    $inv = Invitacion::findOrFail($id);

    if (!$inv->correo) {
      return back()->with('error', 'Esta invitación no tiene correo.');
    }

    Mail::to($inv->correo)->send(new \App\Mail\InvitacionConfirmacion($inv));

    return back()->with('success', 'Correo enviado correctamente.');
  }



}

