<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMaSegPf extends Model
{
    use HasFactory;
    protected $table = 'eqop_ma_eqseg_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_eqseguridad',
        'equipo_seguiridad',
        'eqseg_cant',
        'eqseg_tipo_id'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_ma_PF::class, 'emb_pertenece_id', 'id');
    }

    public function TipoEquipoSeguridad(){
        return $this->belongsTo(TipoEqSeg::class, 'eqseg_tipo_id', 'id');
    }
}