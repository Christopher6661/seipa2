<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_dattececon_AF extends Model
{
    use HasFactory;
    protected $table = 'registro_dattececon_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'prodprom_x_mes',
        'prodpromx_mes_peso',
        'prodprom_mes_talla',
        'ciclocultivoultimo_anio',
        'ciclocult_ultanio_mes',
        'capturacosecha_anio',
        'capturacos_anio_peso',
        'captcosanio_mortalidad',
        'destino_autoconsimo',
        'destino_comercializacio',
        'destino_otro',
        'tipo_mercado_local',
        'tipo_mercado_estatal',
        'tipo_mercado_regional',
        'tipo_mercado_otro',
        'fresco_entero',
        'fresco_entero_preckilo',
        'evicerado',
        'evicerado_preciokilo',
        'enhielado',
        'enhielado_preciokilo',
        'otro',
        'otro_preciokilo',
        'fuenfinanza_programa',
        'fuentefianza_anio',
        'costogasto_anualprod'
    ];
    public $timestamps = true;
}
