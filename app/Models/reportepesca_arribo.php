<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportepesca_arribo extends Model
{
    use HasFactory;
    protected $table = 'reportepesca_arribo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dia',
        'mes',
        'anio',
        'especie',
        'volumen_prodkg',
        'talla_promedio',
        'zona_captura',
        'valor_estimado_cap',
        'embarcacion',
        'arte_pesca',
        'metodo_traslado',
        'pesca_incidental',
        'quien_hizo_reporte',
        'nombre_hizo_rep'
    ];
    public $timestamps = true;
}
