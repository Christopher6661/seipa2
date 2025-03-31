<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMaSisConPf extends Model
{
    use HasFactory;
    protected $table = 'eqop_ma_siscon_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'emb_pertenece_id',
        'cuenta_siscon',
        'sistema_conserva',
        'siscon_cant',
        'siscon_tipo_id'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_ma_PF::class, 'emb_pertenece_id', 'id');
    }

    public function TipoSistemaConservacion(){
        return $this->belongsTo(TipoSisCon::class, 'siscon_tipo_id', 'id');
    }
}
