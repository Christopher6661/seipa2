<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_equipoop_PF extends Model
{
    use HasFactory;
    protected $table = 'registro_equipoop_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_sistema_cons',
        'sistema_conserva',
        'siscon_cant',
        'siscon_tipo',
        'cuenta_equipradio',
        'equipo_radiocom',
        'equipradcom_cant',
        'equipradcom_tipo',
        'cuenta_equipseg',
        'equipo_seguridad',
        'equipseg_cant',
        'equipseg_tipo',
        'cuenta_equipmanejo',
        'equipo_manejo',
        'equipman_cant',
        'equipman_tipo'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_me_PF::class, '');
    }
}
