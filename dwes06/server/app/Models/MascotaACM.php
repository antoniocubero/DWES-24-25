<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MascotaACM extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = ['user_id','nombre', 'descripcion', 'tipo', 'publica'];


    //Establecemos la relacion N:1 con el usuario
    public function user(){
        return $this->belongsTo(User::class);
    }
}
