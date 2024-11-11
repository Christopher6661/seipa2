<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroemb_ma_PF extends Model
{
    use HasFactory;
    protected $table = 'registroemb_ma_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_emb_ma',
        'captura_rnpa',
        'matricula',
        'puerto_base',
        'año_construccion',
        'tipo_cubierta_id',
        'material_casco_id',
        'tipo_actividad_pesca',
        'cantidad_patrones',
        'cantidad_motoristas',
        'cant_pescadores',
        'cantpesc_especializados',
        'cant_tripulacion',
        'costo_avituallamiento',
        'medida_eslora',
        'medida_manga',
        'medida_puntal',
        'medida_decalado',
        'medida_arqueo_neto',
        'capacidad_bodega',
        'capacidad_carga',
        'capacidad_tanque',
        'certificado_seguridad'
    ];
    public $timestamps = true;

    public function TipoCubierta(){
        return $this->belongsTo(tipo_cubierta::class, 'tipo_cubierta_id', 'id');
    }

    public function MaterialCasco(){
        return $this->belongsTo(material_casco::class, 'material_casco_id', 'id');
    }
}
