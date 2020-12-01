<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = ['nombre', 'apellido', 'cuil', 'fechaNacimiento',
     'direccion','fechaAlta',
    'fechaBaja', 'curriculum', 'condicion'];

    public function competenciasEmpleado()
    {
        return $this->hasMany('App\CompetenciaEmpleado');
    }
    public function contratos()
    {
        return $this->hasMany(Contrato::class,'empleado_id');
    }
    public function solicitudInasistencia()
    {
        return $this->hasMany(SolicitudInasistencia::class,'solicitud_inasistencia_id');
    }
   
}
