<?php

namespace App\Http\Controllers;

use App\SolicitudInasistencia;
use Exception;
use Illuminate\Http\Request;

class SolicitudInasistenciaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar=='') {
            $solicitudInasistencias = SolicitudInasistencia::join('empleados', 'empleados.id', '=', 'solicitudes_inasistencias.empleado_id')
            ->join('incidencias', 'incidencias.id', '=', 'solicitudes_inasistencias.incidencia_id')
            ->select('solicitudes_inasistencias.*','incidencias.nombre as nombreIncidencia','empleados.nombre as nombreEmpleado','empleados.apellido as apellidoEmpleado')
            ->paginate(3);
        } else {
            $solicitudInasistencias = SolicitudInasistencia::join('empleados', 'empleados.id', '=', 'solicitudes_inasistencias.empleado_id')
            ->join('incidencias', 'incidencias.id', '=', 'solicitudes_inasistencias.incidencia_id')
            ->select('solicitudes_inasistencias.*','incidencias.nombre as nombreIncidencia','empleados.nombre as nombreEmpleado','empleados.apellido as apellidoEmpleado')
            ->where('solicitudes_inasistencias.'.$criterio, 'like', '%'. $buscar . '%')
            ->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $solicitudInasistencias->total(),
                'current_page' => $solicitudInasistencias->currentPage(),
                'per_page'     => $solicitudInasistencias->perPage(),
                'last_page'    => $solicitudInasistencias->lastPage(),
                'from'         => $solicitudInasistencias->firstItem(),
                'to'           => $solicitudInasistencias->lastItem(),
            ],
            'solicitudInasistencias' => $solicitudInasistencias
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        // $rules = [
        //           'nombre' => 'required|unique:solicitudes_inasistencias|max:50'
        //     ];
        // $messages = [
        //         'nombre.unique' => 'Ya se registro  con el :attribute que ingresó.',
        //     ];
        // $this->validate($request, $rules, $messages);
        try {
            if (!$request->ajax()) {
                return redirect('/');
            }

            $solicitudInasistencia = new SolicitudInasistencia();
            $solicitudInasistencia->desde = $request->desde;
            $solicitudInasistencia->hasta = $request->hasta;
            $solicitudInasistencia->motivo = $request->motivo;
            $solicitudInasistencia->incidencia_id=($request->incidencia_id);
            $solicitudInasistencia->empleado_id=($request->empleado_id);
            $solicitudInasistencia->save();

        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }

    public function selectSolicitudInasistencia(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $filtro = $request->filtro;
        if ($filtro=='') {
            $solicitudInasistencias = SolicitudInasistencia::where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        } else {
            $solicitudInasistencias = SolicitudInasistencia::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        }
       
        
        return ['solicitudInasistencias' => $solicitudInasistencias];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $rules = [
            'desde' => 'required',
            'hasta' => 'required',
            'motivo' => 'required',
        ];
        $messages = [
            'desde.required' => 'Debe ingresar el :attribute .',
            'hasta.required' => 'Debe ingresar el :attribute .',
            'motivo.required' => 'Debe ingresar el :attribute .'
        ];
        $this->validate($request, $rules, $messages);
        try {
            $solicitudInasistencia = SolicitudInasistencia::findOrFail($request->id);
            $solicitudInasistencia->desde = $request->desde;
            $solicitudInasistencia->hasta = $request->hasta;
            $solicitudInasistencia->motivo = $request->motivo;
            $solicitudInasistencia->incidencia_id=($request->incidencia_id);
            $solicitudInasistencia->empleado_id=($request->empleado_id);
            $solicitudInasistencia->save();

        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $solicitudInasistencia = SolicitudInasistencia::findOrFail($request->id);
        $solicitudInasistencia->condicion = '0';
        $solicitudInasistencia->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $solicitudInasistencia = SolicitudInasistencia::findOrFail($request->id);
        $solicitudInasistencia->condicion = '1';
        $solicitudInasistencia->save();
    }
}
