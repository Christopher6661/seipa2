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
        Schema::create('motormayor_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('emb_pertenece_id');
            $table->string('marca_motor');
            $table->string('modelo_motor');
            $table->string('potencia');
            $table->string('num_serie');
            $table->string('tiempo');
            $table->enum('tipo_combustible', ['Magna', 'Premium', 'Diesel']);
            $table->boolean('fuera_borda')->default(false);
            $table->string('vida_util_anio');
            $table->string('doc_propiedad');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('emb_pertenece_id')->references('id')->on('registroemb_ma_pf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motormayor_pf');
    }
};
