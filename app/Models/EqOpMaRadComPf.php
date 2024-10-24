<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMaRadComPf extends Model
{
    use HasFactory;
    protected $table = 'eqop_ma_eqradcom_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_eqradiocom',
        'equipo_radiocomun',
        'eqradiocom_cant',
        'eqradiocom_tipo_id'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_ma_PF::class, 'emb_pertenece_id', 'id');
    }

    public function TipoEquipoRadioComunicacion(){
        return $this->belongsTo(TipoEqRadCom::class, 'eqradiocom_tipo_id', 'id');
    }
}
