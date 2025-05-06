<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['nombre', 'fecha', 'tipo', 'horario', 'ubicacion','token'];

    public function invitaciones()
    {
        return $this->hasMany(Invitacion::class);
    }
}
