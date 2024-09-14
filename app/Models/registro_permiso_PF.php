<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_permiso_PF extends Model
{
    use HasFactory;
    protected $table = 'registro_permisos_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folio_permiso',
        'pesqueria',
        'vigencia_permiso_ini',
        'vigencia_permiso_fin',
        'RNPA',
        'permiso_id',
        'tipo_embarcacion'
    ];
    public $timestamps = true;

    public function Permiso(){
        return $this->belongsTo(tipo_permiso::class, 'permiso_id', 'id');
    }
}
