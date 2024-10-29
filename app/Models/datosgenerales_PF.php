<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class datosgenerales_PF extends Model
{
    use HasFactory;
    protected $table = 'datos_generales_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombres',
        'apellido_pa',
        'apellido_ma',
        'RFC',
        'CURP',
        'telefono',
        'email',
        'domicilio',
        'region_id',
        'distrito_id',
        'municipio_id',
        'localidad_id',       
        'grupo_sanguineo',
        'zona_pesca',
        'etnia_id',
        'cuota_captura',
        'acta_constitutiva',
        'cantidad_artepesca',
        'cuenta_permiso',
        'motivo_no_cuenta',
        'cuenta_emb_mayor',
        'motino_cuenta_embma',
        'cant_emb_ma',
        'cant_motores_ma',
        'tipos_motores_ma',
        'cuenta_emb_menores',
        'motino_cuenta_embme',
        'cant_emb_me',
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
