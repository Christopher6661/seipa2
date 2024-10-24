<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reporteacui_csopcs extends Model
{
    use HasFactory;
    protected $table = 'reporteacui_csopcs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dia',
        'mes',
        'anio',
        'especie',
        'volumen_prodkg',
        'talla_promedio',
        'destino_produccion',
        'valor_estimado_cap',
        'siembra_dias',
        'siembra_mes',
        'siembra_anio',
        'unidad_receptora',
        'siembra_especie',
        'numero_organismos',
        'estadio',
        'pais',
        'estado',
        'municipio',
        'localidad',
        'unidad_procedencia',
        'certificado_sanitario',
        'guia_pesca',
        'valor_lote',
        'metodo_traslado',
        'criasemilla_dia',
        'criasemilla_mes',
        'criasemilla_anio',
        'num_organismosem',
        'periodo_prod_ini',
        'periodo_prod_fin',
        'estadio_salida',
        'talla_salida',
        'detino_prod',
        'valor_produccion'
    ];
    public $timestamps = true;
}
