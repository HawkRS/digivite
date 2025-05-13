<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = auth()->user()->rol == 0
            ? User::all()
            : User::where('rol', '>=', 2)->get();

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolesDisponibles = auth()->user()->rol == 0
            ? [0 => 'Super', 1 => 'Admin', 2 => 'Usuario']
            : [2 => 'Usuario'];

        return view('usuarios.form', ['usuario' => new User(), 'rolesDisponibles' => $rolesDisponibles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:0,1,2',
        ]);

        if (auth()->user()->rol == 1 && $request->rol < 2) {
            abort(403, 'No puedes asignar ese rol.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
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
    public function edit(User $usuario)
    {
        if (auth()->user()->rol == 1 && $usuario->rol < 2) {
            abort(403);
        }

        $rolesDisponibles = auth()->user()->rol == 0
            ? [0 => 'Super', 1 => 'Admin', 2 => 'Usuario']
            : [2 => 'Usuario'];

        return view('usuarios.form', compact('usuario', 'rolesDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        if (auth()->user()->rol == 1 && $usuario->rol < 2) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:6|confirmed',
            'rol' => 'required|in:0,1,2',
        ]);

        if (auth()->user()->rol == 1 && $request->rol < 2) {
            abort(403);
        }

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        if (auth()->user()->rol == 1 && $usuario->rol < 2) {
            abort(403);
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
