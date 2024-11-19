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
        Schema::create('registro_dattecprod_am', function (Blueprint $table) {
            $table->id();
            $table->float('area_total');
            $table->float('area_total_actacu');
            $table->float('uso_arearestante');
            $table->boolean('modelo_extensivo')->default(false);
            $table->boolean('modelo_intensivo')->default(false);
            $table->boolean('modelo_semintensivo')->default(false);
            $table->string('modelo_otro');
            $table->string('especies_acuicolas');
            $table->boolean('pozo_profundo')->default(false);
            $table->boolean('presa')->default(false);
            $table->boolean('laguna')->default(false);
            $table->boolean('mar')->default(false);
            $table->boolean('pozo_cieloabierto')->default(false);
            $table->boolean('rio_cuenca')->default(false);
            $table->boolean('arroyo_manantial')->default(false);
            $table->string('otro')->nullable();
            $table->string('especificar_otro');
            $table->enum('forma_alimentacion', ['Bombeo', 'Pozo']);
            $table->decimal('aliment_agua_caudad', 2,8);
            $table->string('desc_equip_acuicola');
            $table->enum('tipo_asistenciatec', ['Asesor pagado', 'Otorgado por institucion']);
            $table->boolean('organismo_laboratorio')->default(false);
            $table->boolean('hormonados_genetica')->default(false);
            $table->boolean('medicam_quimicos')->default(false);
            $table->boolean('aliment_balanceados')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_dattecprod_am');
    }
};
