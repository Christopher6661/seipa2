<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosgenerales_PM extends Model
{
    use HasFactory;
    protected $table = 'datos_generales_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'razon_social',
        'RFC',
        'CURP',
        'telefono',
        'domicilio',
        'region_id',
        'distrito_id',
        'municipio_id',
        'localidad_id',
        'zona_pesca',
        'cuota_captura',
        'cantidad_artespesca',
        'etnia_id',
        'acta_constitutiva',
        'socios',
        'cuenta_permiso',
        'motivo_no_cuenta',
        'cuenta_emba',
        'motivo_nocuenta_embma',
        'cant_emb',
        'cant_motores',
        'tipos_motores',
        'cuenta_embme',
        'motivo_nocuenta_embme',
        'cantidad_embme',
        'cant_motores_me',
        'tipos_motores_me'
    ];
    public $timestamps = true;

    public function Region(){
        return $this->belongsTo(region::class, 'region_id', 'id');
    }

    public function Distrito(){
        return $this->belongsTo(distrito::class, 'distrito_id', 'id');
    }

    public function Municipio(){
        return $this->belongsTo(municipio::class, 'municipio_id', 'id');
    }

    public function Localidad(){
        return $this->belongsTo(localidad::class, 'localidad_id', 'id');
    }

    public function Etnia(){
        return $this->belongsTo(etnia::class, 'etnia_id', 'id');
    }
}
