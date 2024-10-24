<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMeManejoPf extends Model
{
    use HasFactory;
    protected $table = 'eqop_me_eqmanejo_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_eqmanejo',
        'equipo_manejo',
        'eqmanejo_cant',
        'eqmanejo_tipo_id'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_me_PF::class, 'emb_pertenece_id', 'id');
    }

    public function TipoEquipoManejo(){
        return $this->belongsTo(TipoEqManejo::class, 'eqmanejo_tipo_id', 'id');
    }
}
