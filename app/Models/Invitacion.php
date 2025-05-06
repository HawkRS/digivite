<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    protected $table = 'invitaciones'; // Nombre de la tabla
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['evento_id', 'nombre', 'comentario', 'correo', 'telefono', 'tokenid'];
    protected $casts = [ 'confirmado' => 'boolean'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class);
    }
}
