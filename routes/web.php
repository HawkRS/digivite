<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InvitacionController;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('inicio', [HomeController::class, 'index'])->name('home');

Route::get('admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('admin')->group(function () {
    Route::get('dashboard',[HomeController::class, 'dashboard'])->name('dashboard');

    //EVENTOS
    Route::prefix('eventos')->group(function () {
        Route::get('',[EventoController::class, 'index'])->name('eventos.index');
        Route::get('registrar', [EventoController::class, 'create'])->name('eventos.create');
        Route::post('guardar', [EventoController::class, 'store'])->name('eventos.store');
        Route::get('editar/{id}', [EventoController::class, 'edit'])->name('eventos.edit');
        Route::post('actualizar/{id}', [EventoController::class, 'update'])->name('eventos.update');
        Route::post('borrar/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    });

    //INVITACION
    Route::prefix('invitaciones')->group(function () {
        Route::get('',[InvitacionController::class, 'index'])->name('invitaciones.index');
        Route::get('registrar', [InvitacionController::class, 'create'])->name('invitaciones.create');
        Route::post('guardar', [InvitacionController::class, 'store'])->name('invitaciones.store');
        Route::get('editar/{id}', [InvitacionController::class, 'edit'])->name('invitaciones.edit');
        Route::post('actualizar/{id}', [InvitacionController::class, 'update'])->name('invitaciones.update');
        Route::post('borrar/{id}', [InvitacionController::class, 'destroy'])->name('invitaciones.destroy');
        Route::post('/invitaciones/{id}/correo', [InvitacionController::class, 'enviarCorreo'])->name('invitaciones.enviarCorreo');

        // web.php
        Route::get('/confirmar/login/{tokenid}', [InvitacionController::class, 'mostrarLogin'])->name('confirmacion.login');
        Route::post('/confirmar/verificar/{tokenid}', [InvitacionController::class, 'verificarPassword'])->name('confirmacion.store');
        Route::get('/confirmar/{tokenid}', [InvitacionController::class, 'confirmarPublica'])->name('invitacion.publica');
        Route::post('/confirmar/{tokenid}', [InvitacionController::class, 'guardarConfirmacion'])->name('invitacion.confirmar');


    });

    //INVITADOS
    Route::prefix('invitados')->group(function () {
        Route::get('',[InvitadoController::class, 'index'])->name('invitados.index');
        Route::get('registrar', [InvitadoController::class, 'create'])->name('invitados.create');
        Route::post('guardar', [InvitadoController::class, 'store'])->name('invitados.store');
        Route::get('editar/{id}', [InvitadoController::class, 'edit'])->name('invitados.edit');
        Route::post('actualizar/{id}', [InvitadoController::class, 'update'])->name('invitados.update');
        Route::post('borrar/{id}', [InvitadoController::class, 'destroy'])->name('invitados.destroy');
        Route::get('/invitados/control/exportar', [InvitadoController::class, 'exportarPdf'])->name('invitados.exportar');
    });

    Route::prefix('usuarios')->group(function () {
        Route::get('',[UsersController::class, 'index'])->name('users.index');
        Route::get('registrar', [UsersController::class, 'create'])->name('users.create');
        Route::post('guardar', [UsersController::class, 'store'])->name('users.store');
        Route::get('editar/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('actualizar/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::post('borrar/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });
});


