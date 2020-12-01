<?php

namespace App\Http\Controllers;

use App\Contrato;
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
            $contratos = Contrato::orderBy('nombre', 'desc')->paginate(3);
        } else {
            $contratos = Contrato::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('nombre', 'desc')->paginate(3);
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
            $contrato->idpuesto=$request->idpuesto;
            $contrato->idempleado=$request->idempleado;
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

    public function selectContrato(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $filtro = $request->filtro;
        if ($filtro=='') {
            $contratos = Contrato::where('condicion', '=', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc');
        } else {
            $contratos = Contrato::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->select('id', 'nombre')
            ->orderBy('nombre', 'asc');
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
            $contrato->idpuesto=$request->idpuesto;
            $contrato->idempleado=$request->idempleado;
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
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id);
        $contrato->condicion = '0';
        $contrato->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
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
}
