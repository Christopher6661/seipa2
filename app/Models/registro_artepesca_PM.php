<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_artepesca_PM extends Model
{
    use HasFactory;
    protected $table = 'registro_artepesca_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_artepesca_id',
        'medidad_largo',
        'medidad_ancho',
        'material',
        'luz_malla',  
    ];
    public $timestamps = true;

    public function arte_pesca(){
        return $this->belongsTo(arte_pesca::class, 'tipo_artepesca_id', 'id');
    }

    public function especie_objetivo(){
        return $this->belongsToMany(especie::class, 'especieobjetivo_id', 'id');
    }

    public function especies(){
        return $this->belongsToMany(especie::class, 'artepesca_x_especieobjpm', 'artepesca_pm_id', 'especieobjetivo_id');
    }
}    
