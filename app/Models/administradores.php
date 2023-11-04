<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Administradores extends Model
{

    protected $table = 'administradores';
    protected $primaryKey = 'id_usuarios';
    protected $fillable =['id_usuarios'];
    use HasFactory;
    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;
}