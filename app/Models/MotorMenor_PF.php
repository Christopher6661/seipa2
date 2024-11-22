<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorMenor_PF extends Model
{
    use HasFactory;
    protected $table = 'motormenor_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'marca_motor',
        'modelo_motor',
        'potencia',
        'num_serie',
        'tiempo',
        'tipo_combustible',
        'fuera_borda',
        'vida_util_anio',
        'doc_propiedad'
    ];
    public $timestamps = true;

    public function embarcacionpertenece(){
        return $this->belongsTo(registroemb_me_PF::class, 'emb_pertenece_id', 'id');
    }
}
