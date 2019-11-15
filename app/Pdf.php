<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $table = 'pdf';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'datos'];
    protected $hidden = ['created_at', 'updated_at'];
}
