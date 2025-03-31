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
        'userprofile_id',
        'folio_permiso',
        'pesqueria',
        'vigencia_permiso_ini',
        'vigencia_permiso_fin',
        'RNPA',
        'tipo_permiso_id',
        'tipo_emb'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

    public function permiso(){
        return $this->belongsTo(tipo_permiso::class, 'tipo_permiso_id', 'id');
    }
}
