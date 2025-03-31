<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroemb_me_PM extends Model
{
    use HasFactory;
    protected $table = 'registroemb_me_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'nombre_emb',
        'matricula',
        'RNP',
        'modelo_emb',
        'capacidad_emb',
        'vida_util_emb',
        'marca_emb',
        'numpescadores_emb',
        'estado_emb',
        'manga_metros',
        'eslora_metros',
        'capacidad_carga',
        'puntal_metros',
        'certificado_seg_mar',
        'movilidad_emb'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }
}
