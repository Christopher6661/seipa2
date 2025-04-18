<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMaManejoPm extends Model
{
    use HasFactory;
    protected $table = 'eqop_ma_eqmanejo_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'emb_pertenece_id',
        'cuenta_eqmanejo',
        'equipo_manejo',
        'eqmanejo_cant',
        'eqmanejo_tipo_id'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_ma_PM::class, 'emb_pertenece_id', 'id');
    }

    public function TipoEquipoManejo(){
        return $this->belongsTo(TipoEqManejo::class, 'eqmanejo_tipo_id', 'id');
    }
}
