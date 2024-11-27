<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtePescaEspecieObjetivoPM extends Model
{
    use HasFactory;
    protected $table = 'artepesca_x_especieobjpm';
    protected $fillable = [
        'artepesca_pm_id',
        'especieobjetivo_id'
    ];

    public function arte_pesca()
    {
        return $this->belongsTo(arte_pesca::class, 'artepesca_pm_id', 'id');
    }

    public function especies()
    {
        return $this->belongsTo(especie::class, 'especieobjetivo_id', 'id');
    }
}
