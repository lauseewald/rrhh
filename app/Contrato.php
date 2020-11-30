<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    
    protected $fillable = [
        'nombre',
        'inicioLaboral',
        'finLaboral',
        'cantidadHorasDiarias',
        'empleado_id',
        'puesto_id',
        'contrato',
        'descripcion',
        'salario'
    ];
    public function puesto()
    {
        return $this->belongsTo('App\Puesto');
    }
  
   
}
