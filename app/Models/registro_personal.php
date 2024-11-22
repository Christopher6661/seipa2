<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_personal extends Model
{
    use HasFactory;
    protected $table = 'registro_personal';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombres',
        'apellido_pa',
        'apellido_ma',
        'usuario',
        'telefono_prin',
        'telefono_secun',
        'email',
        'password',
        'rol_id'
    ];
    public $timestamps = true;

    public function rol(){
        return $this->belongsTo(rol::class, 'rol_id', 'id');
    }
}
