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
        Schema::create('especieproduce_x_af', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acuicultorfisico_id');
            $table->unsignedBigInteger('especie_prod_id');
            
            $table->foreign('acuicultorfisico_id')->references('id')->on('datos_generales_af')->onDelete('cascade');
            $table->foreign('especie_prod_id')->references('id')->on('especies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especieproduce_x_af');
    }
};
