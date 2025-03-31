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
        Schema::create('registro_adminprod_af', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->integer('num_familias');
            $table->integer('num_mujeres');
            $table->integer('num_hombres');
            $table->integer('total_integrantes');
            $table->string('tipo_tenencia_ua');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_adminprod_af');
    }
};
