<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socio extends Model
{
    use HasFactory;
    protected $table = 'socios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'colaborador_id',
        'CURP',
        'tipo'
    ];
    public $timestamps = true;

    public function colaborador(){
        return $this->belongsTo(datosgenerales_AM::class, 'colaborador_id', 'id');
    }
}
