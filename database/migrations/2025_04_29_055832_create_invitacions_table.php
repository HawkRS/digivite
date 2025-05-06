<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitacionsTable extends Migration
{
    public function up()
    {
        Schema::create('invitaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->string('nombre');
            $table->text('comentario')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('tokenid')->unique();
            // En migración de invitaciones
            $table->integer('boletos')->default(1);
            $table->boolean('confirmado')->default(false); // o puede ser nullable si manejas por invitado
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitaciones');
    }
}
