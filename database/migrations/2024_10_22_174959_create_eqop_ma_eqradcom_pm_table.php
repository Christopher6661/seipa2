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
        Schema::create('eqop_ma_eqradcom_pm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emb_pertenece_id');
            $table->boolean('cuenta_eqradiocom')->default(false);
            $table->string('equipo_radiocomun');
            $table->integer('eqradiocom_cant');
            $table->unsignedBigInteger('eqradiocom_tipo_id');  

            $table->foreign('emb_pertenece_id')->references('id')->on('registroemb_ma_pm');
            $table->foreign('eqradiocom_tipo_id')->references('id')->on('tipo_equipo_radcom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqop_ma_eqradcom_pm');
    }
};
