<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMeSisConPf extends Model
{
    use HasFactory;
    protected $table = 'eqop_me_siscon_pf';
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

    public function registroemb_me_pf(){
        return $this->belongsTo(registroemb_me_PF::class, 'emb_pertenece_id', 'id');
    }

    public function TipoSisCon(){
        return $this->belongsTo(TipoSisCon::class, 'siscon_tipo_id', 'id');
    }
}
