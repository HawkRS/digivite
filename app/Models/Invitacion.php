<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitacion extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['evento_id', 'nombre', 'comentario', 'correo', 'telefono', 'tokenid'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class);
    }
}
