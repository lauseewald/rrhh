<?php

use App\Area;
use App\Rol;
use App\AreaEmpresa;
use App\Competencia;
use App\User;
use App\Calendar;
use App\ContactoEmergencia;
use App\Contrato;
use App\Departamento;
use App\DiaNoLaboral;
use App\Empleado;
use App\Empresa;
use App\Evento;
use App\Http\Controllers\EmpleadoController;
use App\Incidencia;
use App\PersonaDependiente;
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
        /* $nuevaArea = new Area();
        $nuevaArea->nombre='Centro de Operaciones';
        $nuevaArea->descripcion='Area Principal';
        $nuevaArea->empresa_id=null;
        $nuevaArea->save(); */

        $nuevaArea = new Area();
        $nuevaArea->nombre='Dirección';
        $nuevaArea->descripcion='Controla todas las áreas de trabajo que se encuentran en la empresa.';
        $nuevaArea->empresa_id=null;
        $nuevaArea->save();

        $nuevaArea2 = new Area();
        $nuevaArea2->nombre='Administración';
        $nuevaArea2->descripcion='Relacionada con el funcionamiento de la empresa';
        $nuevaArea2->empresa_id=null;
        $nuevaArea2->save();

        $nuevaArea3 = new Area();
        $nuevaArea3->nombre='Contabiliad y Finanzas';
        $nuevaArea3->descripcion='Tendrá en cuenta todos los movimientos de dinero, tanto dentro como fuera de la empresa, que también en algunas veces pueden estar almacenadas en bancos o en una caja fuerte.';
        $nuevaArea3->empresa_id=null;
        $nuevaArea3->save();

        $nuevaArea4 = new Area();
        $nuevaArea4->nombre='Tecnologías de la información';
        $nuevaArea4->descripcion='Es el área responsable de desarrollar la estructura tecnológica, el hardware, el software y las redes de computadoras dentro de la organización.';
        $nuevaArea4->empresa_id=null;
        $nuevaArea4->save();
        
        $nuevaCompetencia = new Competencia();
        $nuevaCompetencia->nombre='Liderazgo';
        $nuevaCompetencia->save();

        $nuevaCompetencia = new Competencia();
        $nuevaCompetencia->nombre='Comunicación';
        $nuevaCompetencia->save();

        $nuevaCompetencia = new Competencia();
        $nuevaCompetencia->nombre='Trabajo en Equipo';
        $nuevaCompetencia->save();

        $nuevaCompetencia = new Competencia();
        $nuevaCompetencia->nombre='Creatividad';
        $nuevaCompetencia->save();
        
        $departamento = new Departamento();
        $departamento->nombre='Desarrollo de Software';
        $departamento->descripcion='Programacion, analisis, diseño, etc';
        $departamento->area_id=$nuevaArea->id;
        $departamento->save();
        
        $empleado = new Empleado();
        $empleado->nombre='Ana';
        $empleado->apellido='Rafaela';
        $empleado->cuil='27377048844';
        $empleado->fechaNacimiento= Carbon::createFromFormat('Y-m-d', '1980-01-12');
        $empleado->fechaBaja= null;
        $empleado->fechaAlta= Carbon::createFromFormat('Y-m-d','1990-11-22');
        $empleado->direccion='Belgrano 10000';
        $empleado->estadoCivil='Soltero/a';
        $empleado->save();
        
        $empleado2 = new Empleado();
        $empleado2->nombre='Agus';
        $empleado2->apellido='Britez';
        $empleado2->cuil='27377048844';
        $empleado2->fechaNacimiento= Carbon::createFromFormat('Y-m-d', '1990-01-12');
        $empleado2->fechaBaja= null;
        $empleado2->fechaAlta= Carbon::createFromFormat('Y-m-d','2010-11-22');
        $empleado2->direccion='Belgrano 10000';
        $empleado2->estadoCivil='Soltero/a';
        $empleado2->save();

        $dependiente = new PersonaDependiente();
        $dependiente->nombre='Rafael';
        $dependiente->apellido='Robert';
        $dependiente->dni='50.123.313';
        $dependiente->relacion='Hermano/a';
        $dependiente->necesidad='Discapacidad';
        $dependiente->empleado_id=$empleado->id;
        $dependiente->save();

        $puesto = new Puesto();
        $puesto->nombre='Programacion';
        $puesto->descripcion='Programacion';
        $puesto->sueldoBasico=16000.0;
        $puesto->departamento_id=$departamento->id;
        $puesto->save();

        $tipoContrato = new TipoContrato();
        $tipoContrato->nombre='Prueba';
        $tipoContrato->diasMaximo=90;
        $tipoContrato->diasMinimo=30;
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
        
        $rol1 = new Rol();
        $rol1->nombre='Administrador';
        $rol1->descripcion='...';
        $rol1->save();

        $rol2 = new Rol();
        $rol2->nombre='Empleado';
        $rol2->descripcion='...';
        $rol2->save();
        
        $empresa = new Empresa();
        $empresa->nombre='Angaus Producciones ';
        $empresa->razonSocial='Sociedad Anonima';
        $empresa->cuit='30707831320';
        $empresa->direccion='Debajo del puente';
        $empresa->inicioActividad=Carbon::createFromFormat('Y-m-d','1990-02-25');
        $empresa->save();
        $nuevaArea->empresa_id=$empresa->id;
        $nuevaArea->update();

        $user = new User();
        $user->usuario='root';
        $user->email='root@root.com';
        $user->empresa_id=$empresa->id;
        $user->empleado_id=$empleado->id;
        $user->rol_id=$rol1->id;
        $user->password = bcrypt('root');
        $user->save();

        $user = new User();
        $user->usuario='empleado';
        $user->email='empleado@empleado.com';
        $user->empresa_id=$empresa->id;
        $user->empleado_id=$empleado2->id;
        $user->rol_id=$rol2->id;
        $user->password = bcrypt('empleado');
        $user->save();
        
        $diaNoLaboral = new DiaNoLaboral();
        $diaNoLaboral->dia=Carbon::createFromFormat('Y-m-d','2020-05-25');
        $diaNoLaboral->descripcion='Dia de ';
        $diaNoLaboral->empresa_id= $empresa->id;
        $diaNoLaboral->save();

        $evento = new Evento();
        $evento->titulo='Evento 1';
        $evento->descripcion='Un evento';
        $evento->fecha=Carbon::createFromFormat('Y-m-d H','2021-02-25 14');
        $evento->fechaFin=Carbon::createFromFormat('Y-m-d H','2021-02-26 17');
        $evento->departamento_id=$departamento->id;
        $evento->empresa_id=$empresa->id;
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Año Nuevo';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-01-01');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-01-01');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Carnaval';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-02-15');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-02-16');
        $evento->save();

    

        $evento = new Calendar();
        $evento->event_name='Día Internacional de la Mujer';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-03-08');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-03-08');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día la Memoria, Verdad y Justicia';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-03-24');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-03-24');
        $evento->save();


        $evento = new Calendar();
        $evento->event_name='Jueves Santo';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-04-01');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-04-01');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Viernes Santo';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-04-02');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-04-02');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Pascuas Judías';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-04-03');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-04-04');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día del Veterano y de los Caídos en la Guerra de Malvinas';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-04-02');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-04-02');
        $evento->save();
        
        $evento = new Calendar();
        $evento->event_name='Día del Trabajador';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-05-01');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-05-01');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Puente Turístico';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-05-24');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-05-24');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día de la Revolucón de Mayo';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-05-25');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-05-25');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Paso a la Inmortalidad del General Manuel Belgrano';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-06-20');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-06-20');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Paso a la Inmortalidad del General Martín Miguel de Güemes';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-06-21');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-06-21');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día de la Independencia';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-07-09');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-07-09');
        $evento->save();

       
        $evento = new Calendar();
        $evento->event_name='Día del Paso a la Inmortalidad del Gral. José de San Martín';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-08-16');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-08-16');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día del Respeto a la Diversidad Cultural';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-10-11');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-10-11');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Puente Turístico';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-10-08');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-10-08');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Día de la Soberanía Nacional';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-11-20');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-11-20');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Puente Turístico';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-11-22');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-11-22');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Inmaculada Concepción de María';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-12-08');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-12-08');
        $evento->save();

        $evento = new Calendar();
        $evento->event_name='Navidad';
        $evento->start_date=Carbon::createFromFormat('Y-m-d','2021-12-25');
        $evento->end_date=Carbon::createFromFormat('Y-m-d','2021-12-25');
        $evento->save();


        $incidencia = new Incidencia();
        $incidencia->nombre='Vacaciones';
        $incidencia->diasMaximo=30;
        $incidencia->diasMinimo=10;
        $incidencia->save();

        $incidencia = new Incidencia();
        $incidencia->nombre='Licencia';
        $incidencia->diasMaximo=30;
        $incidencia->diasMinimo=1;
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
