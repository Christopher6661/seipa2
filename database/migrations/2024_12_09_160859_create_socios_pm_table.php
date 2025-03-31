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
        Schema::create('socios_pm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('pescadormoral_id');
            $table->string('CURP');
            $table->boolean('tipo')->default(false);

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('pescadormoral_id')->references('id')->on('datos_generales_pm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios_pm');
    }
};
