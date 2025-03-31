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
        Schema::create('registroemb_ma_pm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->string('nombre_emb_ma');
            $table->string('captura_rnpa');
            $table->string('matricula');
            $table->string('puerto_base');
            $table->date('año_construccion');
            $table->unsignedBigInteger('tipo_cubierta_id');
            $table->unsignedBigInteger('material_casco_id');
            $table->string('tipo_actividad_pesca');
            $table->integer('cantidad_patrones');
            $table->integer('cantidad_motoristas');
            $table->integer('cant_pescadores');
            $table->integer('cantidad_pesc_espe');
            $table->integer('cantidad_tripulacion');
            $table->float('costo_avituallamiento');
            $table->float('medida_eslora_mts');
            $table->float('medida_manga_mts');
            $table->float('medida_puntal_mts');
            $table->float('medida_calado_mts');
            $table->float('medida_arquneto_mts');
            $table->float('capacidadbodega_mts');
            $table->float('capacidad_carga_ton');
            $table->float('capacidad_tanque_lts');
            $table->string('certificado_seg_mar');

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
        Schema::dropIfExists('registroemb_ma_pm');
    }
};
