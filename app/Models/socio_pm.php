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
        'CURP',
        'tipo'
    ];
    public $timestamps = true;

  
    
}
