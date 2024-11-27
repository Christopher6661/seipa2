<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtePescaEspecieObjetivoPF extends Model
{
    use HasFactory;
    protected $table = 'artepesca_x_especieobjpf';
    protected $fillable = [
        'artepesca_pf_id',
        'especieobjetivo_id'
    ];

    public function arte_pesca()
    {
        return $this->belongsTo(arte_pesca::class, 'artepesca_pf_id', 'id');
    }

    public function especies()
    {
        return $this->belongsTo(especie::class, 'especieobjetivo_id', 'id');
    }
}
