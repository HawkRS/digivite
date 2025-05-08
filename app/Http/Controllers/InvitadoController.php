<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitacion;
use App\Models\Invitado;
use App\Models\Evento;
use Carbon\Carbon;
use PDF;

class InvitadoController extends Controller
{
    private $f = 'admin.invitados.';

    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
       $filtro = $request->get('filtro', 'todos');

       $query = Invitado::with('invitacion.evento');

       if ($filtro === 'confirmados') {
         $query->where('confirmado', true);
       } elseif ($filtro === 'no_confirmados') {
         $query->where('confirmado', false);
       }

       $invitados = $query->get();

       return view($this->f.'index', compact('invitados', 'filtro'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
         {
             $invitado = Invitado::create($request->validate([
                 'invitacion_id' => 'required|exists:invitacions,id',
                 'nombre' => 'required|string|max:255',
             ]));

             return response()->json($invitado, 201);
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


    public function exportarPdf(Request $request)
    {
      $filtro = $request->get('filtro', 'todos');

      $query = Invitado::with('invitacion.evento');

      if ($filtro === 'confirmados') {
        $query->where('confirmado', true);
      } elseif ($filtro === 'no_confirmados') {
        $query->where('confirmado', false);
      }

      $invitados = $query->get();

      $pdf = \PDF::loadView('admin.invitados.reporte', compact('invitados', 'filtro'));
      return $pdf->download("lista_invitados_{$filtro}.pdf");
    }
}
