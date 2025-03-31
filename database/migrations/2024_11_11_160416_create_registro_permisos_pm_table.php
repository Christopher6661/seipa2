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
            $table->unsignedBigInteger('userprofile_id');
            $table->string('folio_permiso');
            $table->string('pesqueria');
            $table->date('vigencia_permiso_ini');
            $table->date('vigencia_permiso_fin');
            $table->string('RNPA');
            $table->unsignedBigInteger('tipo_permiso_id');
            $table->boolean('tipo_emb')->default(false);

            $table->foreign('userprofile_id')->references('id')->on('users');
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
