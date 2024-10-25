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
        Schema::create('registro_pm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ofregistro_id');
            $table->string('razon_social');
            $table->string('RFC');
            $table->string('CURP');
            $table->string('usuario')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('tipo_actividad')->default(false);
            $table->boolean('tipo_persona')->default(false);

            $table->foreign('ofregistro_id')->references('id')->on('oficinas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_pm');
    }
};
