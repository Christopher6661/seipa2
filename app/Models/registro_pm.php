<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_pm extends Model
{
    use HasFactory;
    protected $table = 'registro_pm';
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

    public function oficinas(){
        return $this->belongsTo(oficina::class, 'oficregis_id', 'id');
    }
}
