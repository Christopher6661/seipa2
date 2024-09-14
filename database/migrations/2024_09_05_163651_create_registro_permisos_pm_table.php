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
        Schema::create('registro_permisos_pm', function (Blueprint $table) {
            $table->id();
            $table->string('folio_permiso');
            $table->string('pesqueria');
            $table->date('vigencia_permiso_ini');
            $table->date('vigencia_permiso_fin');
            $table->string('cantidad_emb');
            $table->string('tipos_emb');
            $table->string('cantidad_motores');
            $table->unsignedBigInteger('tipo_permiso_id');
            $table->string('tipos_motores');
            $table->string('RNPA');
            $table->string('cantidad_artpesca');

            $table->foreign('tipo_permiso_id')->references('id')->on('tipo_permisos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_permisos_pm');
    }
};
