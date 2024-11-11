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
        'especie_objetivo'  
    ];
    public $timestamps = true;

    public function arte_pesca(){
        return $this->belongsTo(arte_pesca::class, 'tipo_artepesca_id', 'id');
    }

    public function especie_objetivo(){
        return $this->belongsTo(especie::class, 'especie_obj_id', 'id');
    }
}    
