<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_af extends Model
{
    use HasFactory;
    protected $table = 'registro_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ofregistro_id',
        'nombres',
        'apellido_pa',
        'apellido_ma',
        'usuario',
        'password',
        'email',
        'tipo_actividad',
        'tipo_persona'
    ];
    public $timestamps = true;

    public function OficinaRegistro(){
        return $this->belongsTo(oficina::class, 'ofregistro_id', 'id');
    }
}
