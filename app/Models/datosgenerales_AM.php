<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosgenerales_AM extends Model
{
    use HasFactory;
    protected $table = 'datos_generales_am';
    protected $primaryKey = 'id';
    protected $fillable = [
        'razon_social',
        'RFC',
        'CURP',
        'telefono',
        'domicilio',
        'local_id',
        'muni_id',
        'distrito_id',
        'region_id',
        'email',
        'especies_producen',
        'socios',
        'etnia_id',
        'cuenca_siscuarente',
        'motivo_no_cuenta'
    ];
    public $timestamps = true;
}
