<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_artepesca_PF extends Model
{
    use HasFactory;
    protected $table = 'registro_artepesca_pf';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'tipo_artepesca_id',
        'medidas_metros',
        'longitud',
        'material',
        'luz_malla'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

    public function arte_pesca(){
        return $this->belongsTo(arte_pesca::class, 'tipo_artepesca_id', 'id');
    }
    
    public function especieobjetivo(){
        return $this->belongsTo(especie::class, 'especie_obj_id', 'id');
    }

    public function esp_objetivo() {
        return $this->belongsToMany(especie::class, 'artepesca_x_especieobjpf', 'artepesca_pf_id', 'especieobjetivo_id');
    }

    }
