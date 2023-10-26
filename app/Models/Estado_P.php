<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Estado_P extends Model
{
    protected $table = 'estados_p';
    use HasFactory;
    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;
}
