<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socio_pm extends Model
{
    use HasFactory;
    protected $table = 'socios_pm';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pescadormoral_id',
        'CURP',
        'tipo'
    ];
    public $timestamps = true;

    public function colaborador(){
        return $this->belongsTo(datosgenerales_PM::class, 'pescadormoral_id', 'id');
    }
}
