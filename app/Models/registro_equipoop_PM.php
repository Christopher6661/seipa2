<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_equipoop_PM extends Model
{
    use HasFactory;
    protected $table = 'registro_equipoop_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'equipo_deteccion',
        'sistema_conserva',
        'sisconse_cant',
        'sisconse_tipo',
        'equipo_radiocomun',
        'equradiocom_cant',
        'equradiocom_tipo',
        'equipo_seguridad',
        'equipo_seg_cant',
        'equipo_seg_tipo',
        'equipo_manejo',
        'equimanejo_cant',
        'equimanejo_tipo'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_me_PM::class, 'emb_pertenece_id', 'id');
    }
}
