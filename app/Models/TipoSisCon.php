<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSisCon extends Model
{
    use HasFactory;
    protected $table = 'tipo_sistconservacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tipo_siscon'
    ];
    public $timestamps = true;
}
