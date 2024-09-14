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
        Schema::create('registro_personal', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellido_pa');
            $table->string('apellido_ma');
            $table->string('usuario');
            $table->string('telefono_prin');
            $table->string('telefono_secun');
            $table->string('email');
            $table->string('password');
            $table->unsignedBigInteger('rol_id');
            
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_personal');
    }
};
