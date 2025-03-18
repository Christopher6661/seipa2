<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroemb_ma_PM extends Model
{
    use HasFactory;
    protected $table = 'registroemb_ma_pm';
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
        'cantidad_pesc_espe',
        'cantidad_tripulacion',
        'costo_avituallamiento',
        'medida_eslora_mts',
        'medida_manga_mts',
        'medida_puntal_mts',
        'medida_calado_mts',
        'medida_arquneto_mts',
        'capacidadbodega_mts',
        'capacidad_carga_ton',
        'capacidad_tanque_lts',
        'certificado_seg_mar'
    ];
    public $timestamps = true;

    public function tipocubierta(){
        return $this->belongsTo(tipo_cubierta::class, 'tipo_cubierta_id', 'id');
    }

    public function materialcasco(){
        return $this->belongsTo(material_casco::class, 'material_casco_id', 'id');
    }
}
