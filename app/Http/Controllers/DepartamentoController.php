<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
    if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar=='') {
            $departamentos = Departamento::join('areas','departamento.area_id','=','areas.id')
            ->select('departamentos.nombre as nombreDepartamento', 'areas.nombre as nombreArea')
            ->orderBy('departamentos.nombre', 'desc')->paginate(3);
            
        } else {
            $departamentos = Departamento::join('areas','departamento.area_id','=','areas.id')
            ->select('departamentos.nombre as nombreDepartamento', 'areas.nombre as nombreArea')
            ->where('departamentos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('departamentos.nombre', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $departamentos->total(),
                'current_page' => $departamentos->currentPage(),
                'per_page'     => $departamentos->perPage(),
                'last_page'    => $departamentos->lastPage(),
                'from'         => $departamentos->firstItem(),
                'to'           => $departamentos->lastItem(),
            ],
            'departamentos' => $departamentos
        ];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
           $rules = [
                  'titulo' => 'required|max:100'  
            ];
            $messages = [
                'nombre.max' => 'La longitud maxima del :attribute es 100 caracteres.',
            ];
            $this->validate($request, $rules, $messages);            
                try{
                    if (!$request->ajax()) return redirect('/');
                    $evento = new Evento();
                    $evento->titulo = $request->titulo;
                    $evento->descripcion = $request->descripcion;
                    $evento->fecha = $request->fecha;
                    $evento->departamento_id=$request->iddepartamento;
                    $evento->empresa_id=$request->idempresa;
                    $evento->save();
                } catch (Exception $e){
                    return redirect()->withErrors('Error'); 
                }        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rules = [
            'titulo' => 'required|max:100'  
        ];
        $messages = [
            'nombre.max' => 'La longitud maxima del :attribute es 100 caracteres.',
        ];
            $this->validate($request, $rules, $messages);
            try{
                
            $evento = Evento::findOrFail($request->id);
            $evento->titulo = $request->titulo;
            $evento->descripcion = $request->descripcion;
            $evento->fecha = $request->fecha;
            $evento->departamento_id=$request->iddepartamento;
            $evento->empresa_id=$request->idempresa;
            $evento->condicion = '1';
            $evento->save();
            
            
        } catch (Exception $e){
            return redirect()->withErrors('Error');
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $evento = Evento::findOrFail($request->id);
        $evento->condicion = '0';
        $evento->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $evento = Evento::findOrFail($request->id);
        $evento->condicion = '1';
        $evento->save();
    }

    public function selectDepartamento(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        if ($filtro==''){
            $departamentos = Departamento::where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
            
        } else {
            $departamentos = Departamento::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
        }
        
        return ['departamentos' => $departamentos];
    }
}
