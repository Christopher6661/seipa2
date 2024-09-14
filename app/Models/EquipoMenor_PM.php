<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoMenor_PM extends Model
{
    use HasFactory;
    protected $table = 'equipo_menor_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_siscon',
        'sistema_conserva',
        'siscon_cant',
        'siscon_tipo',
        'cuenta_eqradiocom',
        'equipo_radiocomun',
        'eqradiocom_cant',
        'eqradiocom_tipo',
        'cuenta_eqseguridad',
        'equipo_seguridad',
        'eqseg_cant',
        'eqseg_tipo',
        'cuenta_eqmanejo',
        'equipo_manejo',
        'eqmanejo_cant',
        'eqmanejo_tipo'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_me_PM::class, 'emb_pertenece_id', 'id');
    }
}
