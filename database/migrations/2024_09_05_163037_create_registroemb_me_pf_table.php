<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registroemb_me_pf', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_emb')->unique();
            $table->string('matricula');
            $table->string('RNP');
            $table->string('modelo_emb');
            $table->string('capacidad_emb');
            $table->string('vida_util_emb');
            $table->string('marca_emb');
            $table->string('numpescadores_emb');
            $table->enum('estado_emb', ['Bueno', 'Malo', 'Deplorable']);
            $table->float('manga_metros');
            $table->float('eslora_metros');
            $table->string('capacidad_carga');
            $table->float('puntal_metros');
            $table->string('certificado_seg_mar');
            $table->string('movilidad_emb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registroemb_me_pf');
    }
};
