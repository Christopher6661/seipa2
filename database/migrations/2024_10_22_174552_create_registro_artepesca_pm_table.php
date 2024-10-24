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
        Schema::create('registro_artepesca_pm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_artepesca_id');
            $table->float('medida_largo');
            $table->float('medida_ancho');
            $table->string('material');
            $table->float('luz_malla');
            $table->string('especie_objetivo');          
          
            $table->foreign('tipo_artepesca_id')->references('id')->on('arte_pesca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_artepesca_pm');
    }
};
