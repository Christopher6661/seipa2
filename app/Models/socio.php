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
        'userprofile_id',
        'CURP',
        'tipo'
    ];
    public $timestamps = true;

    public function perfil_usuario(){
        return $this->belongsTo(User::class, 'userprofile_id', 'id');
    }

}
