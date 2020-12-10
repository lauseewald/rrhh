<?php

namespace App\Http\Controllers;

use App\TipoContrato;
use Exception;
use Illuminate\Http\Request;

class TipoContratoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            
            $tipoContrato = TipoContrato::orderBy('nombre', 'desc')->paginate(3);
        }
        else{
           
            $tipoContrato = TipoContrato::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('nombre', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $tipoContrato->total(),
                'current_page' => $tipoContrato->currentPage(),
                'per_page'     => $tipoContrato->perPage(),
                'last_page'    => $tipoContrato->lastPage(),
                'from'         => $tipoContrato->firstItem(),
                'to'           => $tipoContrato->lastItem(),
            ],
            'tipoContratos' => $tipoContrato
        ];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
           $rules = [
                  'nombre' => 'required|unique:competencias|max:150'  
            ];
            $messages = [
                'nombre.unique' => 'Ya se registro una competencia con el :attribute que ingresó.',
            ];
            $this->validate($request, $rules, $messages);            
                try{
                    if (!$request->ajax()) return redirect('/');
                    $tipoContrato = new TipoContrato();
                    $tipoContrato->nombre = $request->nombre;
                    $tipoContrato->save();
                } catch (Exception $e){
                    //return redirect()->withErrors('Error'); 
                }        
    }
    
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            $rules = [
                'nombre' => 'required|max:150'
                
            ];
            $messages = [
                'nombre.required' => 'Debe ingresar el :attribute .',
            
            ];
            $this->validate($request, $rules, $messages);
            try{
                
            $tipoContrato = TipoContrato::findOrFail($request->id);
            $tipoContrato->nombre = $request->nombre;
            $tipoContrato->condicion = '1';
            $tipoContrato->save();
            
            
        } catch (Exception $e){
            //return redirect()->withErrors('Error');
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipoContrato = TipoContrato::findOrFail($request->id);
        $tipoContrato->condicion = '0';
        $tipoContrato->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipoContrato = TipoContrato::findOrFail($request->id);
        $tipoContrato->condicion = '1';
        $tipoContrato->save();
    }

    public function selectTipoContrato(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        if ($filtro==''){
            $tipoContrato = TipoContrato::where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
            
        } else {
            $tipoContrato = TipoContrato::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
        }
        
        return ['tipoContratos' => $tipoContrato];
    }
}
