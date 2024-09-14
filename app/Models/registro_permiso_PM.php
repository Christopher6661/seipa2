<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_permiso_PM extends Model
{
    use HasFactory;
    protected $table = 'registro_permisos_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folio_permiso',
        'pesqueria',
        'vigencia_permiso_ini',
        'vigencia_permiso_fin',
        'RNPA',
        'tipo_permiso_id',
        'tipo_emb'
    ];
    public $timestamps = true;

    public function Permiso(){
        return $this->belongsTo(tipo_permiso::class, 'tipo_permiso_id', 'id');
    }
}
