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
        Schema::create('equipo_mayor_pf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emb_pertenece_id');
            $table->boolean('cuenta_siscon')->default(false);
            $table->string('sistema_conserva');
            $table->integer('siscon_cant');
            $table->string('siscon_tipo');
            $table->boolean('cuenta_eqradiocom')->default(false);
            $table->string('equipo_radiocomun');
            $table->integer('eqradiocom_cant');
            $table->string('eqradiocom_tipo');                                            	    
            $table->boolean('cuenta_eqseguridad')->default(false);
            $table->string('equipo_seguiridad');
            $table->integer('eqseg_cant');
            $table->string('eqseg_tipo');
            $table->boolean('cuenta_eqmanejo')->default(false);
            $table->string('equipo_manejo');
            $table->integer('eqmanejo_cant');
            $table->string('eqmanejo_tipo');
    
            $table->foreign('emb_pertenece_id')->references('id')->on('registroemb_ma_pf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_mayor_pf');
    }
};
