<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_dattecprod_AM extends Model
{
    use HasFactory;
    protected $table = 'registro_dattecprod_am';
    protected $primaryKey = 'id';
    protected $fillable = [
        'area_total',
        'area_total_actacu',
        'uso_arearestante',
        'modelo_extensivo',
        'modelo_intensivo',
        'modelo_semintensivo',
        'modelo_otro',
        'especies_acuicolas',
        'pozo_profundo',
        'presa',
        'laguna',
        'mar',
        'pozo_cieloabierto',
        'rio_cuenca',
        'arroyo_manantial',
        'otro',
        'especificar_otro',
        'forma_alimentacion',
        'aliment_agua_caudad',
        'desc_equip_acuicola',
        'tipo_asistenciatec',
        'organismo_laboratorio',
        'hormonados_genetica',
        'medicam_quimicos',
        'aliment_balanceados'
    ];
}
