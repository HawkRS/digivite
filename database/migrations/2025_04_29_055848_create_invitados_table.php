<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitadosTable extends Migration
{
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitacion_id')->constrained('invitaciones')->onDelete('cascade');
            $table->string('nombre');
            $table->boolean('es_ancla')->default(false);
            $table->boolean('confirmado')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitados');
    }
}
