<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EqOpMeSisConPm extends Model
{
    use HasFactory;
    protected $table = 'eqop_me_siscon_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'emb_pertenece_id',
        'cuenta_siscon',
        'sistema_conserva',
        'siscon_cant',
        'siscon_tipo_id'
    ];
    public $timestamps = true;

    public function EmbarcacionPertenece(){
        return $this->belongsTo(registroemb_me_PM::class, 'emb_pertenece_id', 'id');
    }

    public function TipoSistemaConservacion(){
        return $this->belongsTo(TipoSisCon::class, 'siscon_tipo_id', 'id');
    }
}
