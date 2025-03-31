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
        Schema::create('eqop_me_eqradcom_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('emb_pertenece_id');
            $table->boolean('cuenta_eqradiocom')->default(false);
            $table->string('equipo_radiocomun');
            $table->integer('eqradiocom_cant');
            $table->unsignedBigInteger('eqradiocom_tipo_id');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('emb_pertenece_id')->references('id')->on('registroemb_me_pf');
            $table->foreign('eqradiocom_tipo_id')->references('id')->on('tipo_equipo_radcom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqop_me_eqradcom_pf');
    }
};
