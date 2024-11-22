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
        'oficregis_id',
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

    public function oficinas(){
        return $this->belongsTo(oficina::class, 'oficregis_id', 'id');
    }
}
