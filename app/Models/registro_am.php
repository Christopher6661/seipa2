<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_am extends Model
{
    use HasFactory;
    protected $table = 'registro_am';
    protected $primaryKey = 'id';
    protected $fillable = [
        'oficregis_id',
        'razon_social',
        'RFC',
        'CURP',
        'usuario',
        'password',
        'email',
        'tipo_actividad',
        'tipo_persona'
    ];
    public $timestamps = true;

    public function Oficinas(){
        return $this->belongsTo(oficina::class, 'oficregis_id', 'id');
    }
}
