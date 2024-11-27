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
        Schema::create('artepesca_x_especieobjpm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artepesca_pm_id');
            $table->unsignedBigInteger('especieobjetivo_id');

            $table->foreign('artepesca_pm_id')->references('id')->on('arte_pesca')->onDelete('cascade');
            $table->foreign('especieobjetivo_id')->references('id')->on('especies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artepesca_x_especieobjpm');
    }
};
