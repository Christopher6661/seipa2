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
        Schema::create('registro_af', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oficregis_id');
            $table->string('nombres');
            $table->string('apellido_pa');
            $table->string('apellido_ma');
            $table->string('usuario')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('tipo_actividad')->default(false);
            $table->boolean('tipo_persona')->default(false);

            $table->foreign('oficregis_id')->references('id')->on('oficinas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_af');
    }
};
