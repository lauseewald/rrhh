<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'sueldoBasico', 'departamento_id','condicion'];
}
