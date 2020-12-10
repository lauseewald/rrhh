<?php

namespace App\Http\Controllers;

use App\Contrato;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar=='') {
            $contratos = Contrato::join('empleados', 'contratos.empleado_id', '=', 'empleados.id')
            ->join('puestos', 'contratos.puesto_id', '=', 'puestos.id')
            ->join('tipo_contratos', 'contratos.tipoContrato_id', '=', 'tipo_contratos.id')
            ->select(
                'contratos.*',
                'puestos.nombre as nombrePuesto',
                'empleados.nombre as nombreEmpleado',
                'empleados.apellido as apellidoEmpleado',
                'tipo_contratos.nombre as nombreTipoContrato'
            )->orderBy('contratos.nombre', 'desc')->paginate(3);
        } else {
            $contratos = Contrato::join('empleados', 'contratos.empleado_id', '=', 'empleados.id')
            ->join('puestos', 'contratos.puesto_id', '=', 'puestos.id')
            ->join('tipo_contratos', 'contratos.tipoContrato_id', '=', 'tipo_contratos.id')
            ->select(
                'contratos.*',
                'puestos.nombre as nombrePuesto',
                'empleados.nombre as nombreEmpleado',
                'empleados.apellido as apellidoEmpleado',
                'tipo_contratos.nombre as nombreTipoContrato'
            )->where('contratos.'.$criterio, 'like', '%'. $buscar . '%')
           ->orderBy('contratos.nombre', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $contratos->total(),
                'current_page' => $contratos->currentPage(),
                'per_page'     => $contratos->perPage(),
                'last_page'    => $contratos->lastPage(),
                'from'         => $contratos->firstItem(),
                'to'           => $contratos->lastItem(),
            ],
            'contratos' => $contratos
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //   return $request;
        if (!$request->ajax()) {
            return redirect('/');
        }
        $rules = [
                  'nombre' => 'required|unique:contratos|max:50'
            ];
        $messages = [
                'nombre.unique' => 'Ya se registro  con el :attribute que ingresó.',
            ];
        $this->validate($request, $rules, $messages);
        try {
            if (!$request->ajax()) {
                return redirect('/');
            }
            
            $contrato = new Contrato();
            $contrato->nombre = $request->nombre;
            $contrato->descripcion = $request->descripcion;
            $contrato->inicioLaboral= $request->inicioLaboral;
            $contrato->finLaboral= $request->finLaboral;
            // $contrato->inicioLaboral= Carbon::now();
            // $contrato->finLaboral= Carbon::now();
            $contrato->cantidadHorasDiarias= intval($request->cantidadHorasDiarias);
            $contrato->salario= floatval($request->salario);
            $contrato->contrato = $request->contrato;
            $contrato->puesto_id=($request->idpuesto);
            $contrato->empleado_id=($request->idempleado);
            $contrato->tipoContrato_id=($request->idtipocontrato);

            $contrato->save();
        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }

    public function selectContrato(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $filtro = $request->filtro;
        if ($filtro=='') {
            $contratos = Contrato::where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        } else {
            $contratos = Contrato::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        }
       
        
        return ['contratos' => $contratos];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrato $contrato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $rules = [
            'nombre' => 'required|max:50'
            
        ];
        $messages = [
            'nombre.required' => 'Debe ingresar el :attribute .',
        
        ];
        $this->validate($request, $rules, $messages);
        try {
            $contrato = Contrato::findOrFail($request->id);
            $contrato->nombre = $request->nombre;
            $contrato->nombre = $request->nombre;
            $contrato->puesto_id=$request->idpuesto;
            $contrato->empleado_id=$request->idempleado;
            $contrato->tipoContrato_id=($request->idTipoContrato);
            $contrato->cantidadHorasLaborales=$request->cantidadHorasLaborales;
            $contrato->salario=$request->salario;
            $contrato->inicioLaboral= $request->inicioLaboral;
            $contrato->finLaboral= $request->finLaboral;
            $contrato->contrato = $request->contrato;
            $contrato->save();
        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $contrato = Contrato::findOrFail($request->id);
        $contrato->condicion = '0';
        $contrato->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $contrato = Contrato::findOrFail($request->id);
        $contrato->condicion = '1';
        $contrato->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrato $contrato)
    {
        //
    }

    public function pdfContrato(Request $request)
    {
        $contratos = Contrato::join('tipo_contratos','contratos.tipoContrato_id','=','tipo_contratos.id')
            ->select('contratos.*','tipo_contratos.nombre as nombreTipoContrato');
            
        
        //anido las consultas segun los filtros
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar!='') {
            if ($buscar =='activo') {   
                $contratos->where('contratos.estado', 1);
            } elseif ($buscar =='desactivado') {
                $contratos->where('contratos.estado', 0);
            } else {
                $contratos->where('contratos.'.$criterio, 'like', '%'. $buscar . '%');
            } 
        } 
        $contratos= $contratos->orderBy('nombre', 'desc')->get();
        $buscar= $buscar ? ucfirst($buscar): 'Sin Busqueda';
        $criterio= $criterio ? ucfirst($criterio): 'Sin Criterio';
       
        $count = count($contratos);
        // $count = 1;
        $now= Carbon::now();
        
         $pdf = PDF::loadView('pdf.contrato', ['contratos' => $contratos, 'buscar' => $buscar, 'criterio' => $criterio, 'now' => $now, 'count' => $count]);
        
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $y = $canvas->get_height() - 35;
        $pdf->getDomPDF()->get_canvas()->page_text(500, $y, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream();
    }
}
