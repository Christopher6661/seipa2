<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorMayor_PM extends Model
{
    use HasFactory;
    protected $table = 'motormayor_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
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

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

    public function embarcacionpertenece(){
        return $this->belongsTo(registroemb_ma_PM::class, 'emb_pertenece_id', 'id');
    }
}
