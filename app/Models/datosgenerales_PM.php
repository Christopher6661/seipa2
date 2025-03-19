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
        'oficregis_id',
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
        'cant_artepesca',
        'etnia_id',
        'acta_constitutiva',
        'socios',
        'cuenta_permiso',
        'motivo_no_cuenta',
        'cuentaemb_ma',
        'motivono_cuenta_embma',
        'cant_emb_ma',
        'cant_motor_ma',
        'tipos_motores_ma',
        'cuentaemb_me',
        'motivono_cuenta_embme',
        'cant_emb_me',
        'cant_motor_me',
        'tipos_motores_me'
    ];
    public $timestamps = true;

    public function Oficina(){
        return $this->belongsTo(oficina::class, 'oficregis_id', 'id');
    }

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
