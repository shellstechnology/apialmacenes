<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Camion_Lleva_Lote extends Model
{
    
    protected $table = 'camion_lleva_lote';
    protected $primaryKey='id_lote';
    protected $fillable =['matricula'];
    public $incrementing = false;
    use HasFactory;
    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;
}
