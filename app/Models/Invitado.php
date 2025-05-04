<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['invitacion_id', 'nombre'];

    public function invitacion()
    {
        return $this->belongsTo(Invitacion::class);
    }
}
