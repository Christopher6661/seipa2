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
        Schema::create('registro_artepesca_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_artepesca_id');
            $table->float('medidas_metros');
            $table->float('longitud');
            $table->string('material');
            $table->float('luz_malla');
            $table->unsignedBigInteger('especie_obj_id');         

            $table->foreign('tipo_artepesca_id')->references('id')->on('arte_pesca');
            $table->foreign('especie_obj_id')->references('id')->on('especies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_artepesca_pf');
    }
};
