<?php

use App\Area;
use App\AreaEmpresa;
use App\Competencia;
use App\User;
use App\ContactoEmergencia;
use App\Contrato;
use App\Departamento;
use App\DiaNoLaboral;
use App\Empleado;
use App\Empresa;
use App\Evento;
use App\Http\Controllers\EmpleadoController;
use App\Incidencia;
use App\Puesto;
use App\SolicitudInasistencia;
use App\TipoContrato;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nuevaArea = new Area();
        $nuevaArea->nombre='Centro de Operaciones';
        $nuevaArea->descripcion='Area Principal';
        $nuevaArea->empresa_id=null;
        $nuevaArea->save();
        
        $nuevaCompetencia = new Competencia();
        $nuevaCompetencia->nombre='Liderazgo';
        $nuevaCompetencia->save();
        
        $departamento = new Departamento();
        $departamento->nombre='Desarrollo de Software';
        $departamento->descripcion='Programacion, analsis, diseño, etc';
        $departamento->area_id=$nuevaArea->id;
        $departamento->save();
        
        $empleado = new Empleado();
        $empleado->nombre='Ana';
        $empleado->apellido='Rafaela';
        $empleado->cuil='27-39.123.412-1';
        $empleado->fechaNacimiento= Carbon::createFromFormat('Y-m-d', '1980-01-12');
        $empleado->fechaBaja= null;
        $empleado->fechaAlta= Carbon::createFromFormat('Y-m-d','1990-11-22');
        $empleado->direccion='Belgrano 10000';
        $empleado->curriculum='La jefa de marandu';
        $empleado->save();

        $puesto = new Puesto();
        $puesto->nombre='Programacion';
        $puesto->descripcion='Programacion';
        $puesto->sueldoBasico=16000.0;
        $puesto->departamento_id=$departamento->id;
        $puesto->save();

        $tipoContrato = new TipoContrato();
        $tipoContrato->nombre='Trabajo';
        $tipoContrato->save();

       
        
        $contrato = new Contrato();
        $contrato->nombre='Trabajo';
        $contrato->descripcion='Es un contrato de trabajo';
        $contrato->salario=17000.0;
        $contrato->inicioLaboral=Carbon::createFromFormat('Y-m-d','2005-11-22');
        $contrato->finLaboral=Carbon::createFromFormat('Y-m-d','2025-11-22');
        $contrato->cantidadHorasDiarias=8;
        $contrato->contrato='ubicacion';
        $contrato->puesto_id=$puesto->id;
        $contrato->empleado_id=$empleado->id;
        $contrato->tipoContrato_id=$tipoContrato->id;
        $contrato->save();
        
    
        
        $empresa = new Empresa();
        $empresa->nombre='Angaus Producciones ';
        $empresa->razonSocial='Sociedad Anonima';
        $empresa->cuit='31-40.123.312-7';
        $empresa->direccion='Debajo del puente';
        $empresa->inicioActividad=Carbon::createFromFormat('Y-m-d','1700-02-25');
        $empresa->save();
        $nuevaArea->empresa_id=$empresa->id;
        $nuevaArea->update();

        $user = new User();
        $user->usuario='root';
        $user->email='root@root.com';
        $user->empresa_id=$empresa->id;
        $user->password = bcrypt('root');
        $user->save();
        
        $diaNoLaboral = new DiaNoLaboral();
        $diaNoLaboral->dia=Carbon::createFromFormat('Y-m-d','2020-05-25');
        $diaNoLaboral->descripcion='Dia de ';
        $diaNoLaboral->empresa_id= $empresa->id;
        $diaNoLaboral->save();

        $evento = new Evento();
        $evento->titulo='Evento 1';
        $evento->descripcion='Un evento';
        $evento->fecha=Carbon::createFromFormat('Y-m-d','2021-02-25');
        $evento->departamento_id=$departamento->id;
        $evento->empresa_id=$empresa->id;
        $evento->save();
        
        $incidencia = new Incidencia();
        $incidencia->nombre='Incidencia 1';
        $incidencia->diasMaximo=30;
        $incidencia->diasMinimo=10;
        $incidencia->save();
        
        $solicitudesInasistencias = new SolicitudInasistencia();
        $solicitudesInasistencias->desde=Carbon::createFromFormat('Y-m-d','2020-03-10');
        $solicitudesInasistencias->hasta=Carbon::createFromFormat('Y-m-d','2020-04-10');
        $solicitudesInasistencias->motivo='vacaciones';
        $solicitudesInasistencias->incidencia_id=$incidencia->id;
        $solicitudesInasistencias->empleado_id=$empleado->id;
        $solicitudesInasistencias->save();

        //relacion many to many
        
        $contactoEmergencia = new ContactoEmergencia();
        $contactoEmergencia->nombre='Agustin';
        $contactoEmergencia->telefono1='12312412';
        $contactoEmergencia->telefono2='12312413';
        $contactoEmergencia->correo='agus@agus.com';
        $contactoEmergencia->empleado_id=$empleado->id;
        $contactoEmergencia->save();

    }
}
