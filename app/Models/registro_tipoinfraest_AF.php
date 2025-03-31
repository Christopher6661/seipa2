<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_tipoinfraest_AF extends Model
{
    use HasFactory;
    protected $table = 'registro_tipoinfraest_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'estanque_rustico_sup',
        'estanque_rustico_vol',
        'estanque_rustico_can',
        'recubiertomem_sup',
        'recubiertomem_vol',
        'recubiertomem_can',
        'geomallagallamina_sup',
        'geomallagallamina_vol' ,
        'geomallagallamina_can',
        'tipo_circular_sup',
        'tipo_circular_vol',
        'tipo_circular_can',
        'tipo_rectangular_sup',
        'tipo_rectangular_vol',
        'tipo_rectangular_can',
        'jaula_flotante_sup',
        'jaula_flotante_vol',
        'jaula_flotante_can',
        'cercas_encierros_sup',
        'cercas_encierros_vol',
        'cercas_encierros_can',
        'otro_superficie',
        'otro_volumen',
        'otro_cantidad'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }
}
