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
        'tipo_artepesca_id',
        'medidad_largo',
        'medidad_ancho',
        'material',
        'luz_malla',
        'especie_objetivo'
    ];
    public $timestamps = true;

    public function TipoArtePesca(){
        return $this->belongsTo(arte_pesca::class, 'tipo_artepesca_id', 'id');
    }
}
