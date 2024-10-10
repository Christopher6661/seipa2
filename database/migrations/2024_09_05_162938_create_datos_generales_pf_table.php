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
        Schema::create('datos_generales_pf', function (Blueprint $table) {
            $table->id();
            $table->string('nombres')->unique();
            $table->string('apellido_pa')->unique();
            $table->string('apellido_ma')->unique();
            $table->string('RFC')->unique();
            $table->string('CURP')->unique();
            $table->string('telefono');
            $table->string('email');
            $table->string('domicilio');
            $table->unsignedBigInteger('localidad_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('distrito_id');
            $table->unsignedBigInteger('region_id');
            $table->string('grupo_sanguineo');
            $table->string('zona_pesca');
            $table->string('acta_constitutiva');
            $table->string('cuota_captura');
            $table->unsignedBigInteger('etnia_id');
            $table->integer('cantidad_artepesca');
            $table->boolean('cuenta_permiso')->default(false);
            $table->string('motivo_no_cuenta');
            $table->boolean('cuenta_emb_mayor')->default(false);
            $table->string('motino_cuenta_embma');
            $table->integer('cant_emb_ma');
            $table->integer('cant_motores_ma');
            $table->string('tipos_motores_ma');
            $table->boolean('cuenta_emb_menores')->default(false);
            $table->string('motino_cuenta_embme');
            $table->integer('cant_emb_me');
            $table->integer('cant_motores_me');
            $table->string('tipos_motores_me');
            
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('distrito_id')->references('id')->on('distrito');
            $table->foreign('region_id')->references('id')->on('region');
            $table->foreign('etnia_id')->references('id')->on('etnias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_generales_pf');
    }
};
