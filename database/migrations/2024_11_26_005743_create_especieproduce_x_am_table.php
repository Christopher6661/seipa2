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
        Schema::create('especieproduce_x_am', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acuicultormoral_id');
            $table->unsignedBigInteger('especie_prod_id');
            
            $table->foreign('acuicultormoral_id')->references('id')->on('datos_generales_am')->onDelete('cascade');
            $table->foreign('especie_prod_id')->references('id')->on('especies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especieproduce_x_am');
    }
};
