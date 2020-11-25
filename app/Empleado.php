<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = ['nombre', 'apellido', 'cuil', 'fechaNacimiento',
     'direccion','fechaAlta',
    'fechaBaja', 'curriculum'];
}
