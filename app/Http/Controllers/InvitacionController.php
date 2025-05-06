<?php

namespace App\Http\Controllers;
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
      $this->middleware('auth')->except(['confirmarPublica', 'guardarConfirmacion']);
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
         $validated = $request->validate([
             'evento_id' => 'required|exists:eventos,id',
             'nombre' => 'required|string|max:255',
             'comentario' => 'nullable|string',
             'correo' => 'nullable|email',
             'telefono' => 'nullable|string|max:20',
             'invitados' => 'required|array|min:1',
             'invitados.*' => 'required|string|max:255',
         ]);

         $validated['tokenid'] = Str::uuid(Str::random(8)); // genera un UUID único

         // Crear la invitación
         $invitacion = Invitacion::create($validated);
         $numboletos = 0;

         // Crear los invitados asociados
         foreach ($request->invitados as $nombreInvitado) {
             if (trim($nombreInvitado) !== '') {
                 $numboletos += 1;
                 $invitacion->invitados()->create([
                     'nombre' => $nombreInvitado,
                     'confirmado' => false,
                 ]);
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

    public function guardarConfirmacion(Request $request, $tokenid)
    {
        $invitacion = Invitacion::where('tokenid', $tokenid)->with('invitados')->firstOrFail();
        $confirmados = $request->input('confirmados', []);
        //dd($request->all());
        $numboletos = 0;
        foreach ($invitacion->invitados as $invitado) {
            // Solo actualizar si aún no estaba confirmado
            if (!$invitado->confirmado && in_array($invitado->id, $confirmados)) {
                $invitado->confirmado = true;
                $invitado->save();
                $numboletos += 1;
            }
        }
        $invitacion->boletos = $numboletos;
        $invitacion->confirmado = true;
        $invitacion->save();

        return redirect()->back()->with('success', '¡Confirmación guardada correctamente!');
    }


}
