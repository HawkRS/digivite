<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invitacion;
use App\Models\Invitados;
use App\Models\Evento;
use Carbon\Carbon;

class HomeController extends Controller
{
    private $f = 'public.';
    private $t = 'admin.';

    public function __construct()
    {
      $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $evento = Evento::first();
        //dd($evento);
        return view($this->f.'public', [
          'evento' =>$evento
        ]);
    }

    public function dashboard()
    {
        $evento = Evento::first();
        $invitaciones = Invitacion::with('evento')->latest()->get();
        //dd($evento);
        return view($this->t.'dashboard', [
          'evento' =>$evento,
          'invitaciones' =>$invitaciones,
        ]);
    }

}
