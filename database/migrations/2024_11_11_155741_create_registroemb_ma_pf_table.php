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
        Schema::create('registroemb_ma_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->string('nombre_emb_ma');
            $table->string('captura_rnpa');
            $table->string('matricula');
            $table->string('puerto_base');
            $table->string('año_construccion');
            $table->unsignedBigInteger('tipo_cubierta_id');
            $table->unsignedBigInteger('material_casco_id');
            $table->string('tipo_actividad_pesca');
            $table->integer('cantidad_patrones');
            $table->integer('cantidad_motoristas');
            $table->integer('cant_pescadores');
            $table->integer('cantpesc_especializados');
            $table->integer('cant_tripulacion');
            $table->float('costo_avituallamiento');
            $table->float('medida_eslora');
            $table->float('medida_manga');
            $table->float('medida_puntal');
            $table->float('medida_decalado');
            $table->float('medida_arqueo_neto');
            $table->float('capacidad_bodega');
            $table->float('capacidad_carga');
            $table->float('capacidad_tanque');
            $table->string('certificado_seguridad');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('tipo_cubierta_id')->references('id')->on('tipo_cubierta');
            $table->foreign('material_casco_id')->references('id')->on('material_casco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registroemb_ma_pf');
    }
};
