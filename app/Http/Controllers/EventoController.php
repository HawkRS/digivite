<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventoController extends Controller
{
    private $f = 'admin.evento.';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evento = Evento::first();
        //dd($evento);
        return view($this->f.'index', [
          'evento' =>$evento
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->f.'create');
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
       //$token = str_random(10);
       do {
         $token = Str::random(10);
       } while (Evento::where("token", "=", $token)->first() instanceof Reparaciones);
       //dd($token);
       $request->merge(['token' => $token]);
       //dd($request->all());
       $evento = Evento::create($request->validate([
         'nombre' => 'required|string|max:255',
         'fecha' => 'required|date',
         'tipo' => 'required|string|max:255',
         'horario' => 'required',
         'token' => 'required',
         'ubicacion' => 'required|string|max:255',
       ]));

       $url = route('confirmar.token');

       // Generar QR como imagen PNG
      //$qrImage = QrCode::format('png')->size(300)->generate($url);
       $qrSvg = QrCode::format('svg')->size(300)->generate($url);

       // Guardarlo en /storage/app/public/qrs/{evento_id}.png
       //Storage::put("public/qrs/{$evento->id}.png", $qrImage);
       Storage::put("public/qrs/{$evento->id}.svg", $qrSvg);

       return redirect()->route('eventos.index');
       return response()->json($evento, 201);
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
}
