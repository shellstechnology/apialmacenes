<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


class Lote extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "paquete_contiene_lote";
    public $timestamps = true;
    protected $primaryKey = 'id_paquete';
    public $incrementing = false;
}
