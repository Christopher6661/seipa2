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
        Schema::create('eqop_ma_eqmanejo_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userprofile_id');
            $table->unsignedBigInteger('emb_pertenece_id');
            $table->boolean('cuenta_eqmanejo')->default(false);
            $table->string('equipo_manejo');
            $table->integer('eqmanejo_cant');
            $table->unsignedBigInteger('eqmanejo_tipo_id');

            $table->foreign('userprofile_id')->references('id')->on('users');
            $table->foreign('emb_pertenece_id')->references('id')->on('registroemb_ma_pf');
            $table->foreign('eqmanejo_tipo_id')->references('id')->on('tipo_equipo_manejo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eqop_ma_eqmanejo_pf');
    }
};
