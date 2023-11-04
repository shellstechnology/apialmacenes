<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "paquetes";
    protected $fillable = ['nombre','volumen_l','peso_kg','id_estado_p','id_caracteristica_paquete','id_lugar_entrega','nombre_destinatario','nombre_remitente'];
    public $timestamps = true;
    
}

