<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registro_adminprod_AF extends Model
{
    use HasFactory;
    protected $table = 'registro_adminprod_af';
    protected $primaryKey = 'id';
    protected $fillable = [
        'userprofile_id',
        'num_familias',
        'num_mujeres',
        'num_hombres',
        'total_integrantes',
        'tipo_tenencia_ua'
    ]; 
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }
}
