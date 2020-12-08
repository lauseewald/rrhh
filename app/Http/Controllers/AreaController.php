<?php

namespace App\Http\Controllers;

use App\Area;
use Exception;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar=='') {
            $areas = Area::join('departamentos', 'areas.departamento_id', '=', 'departamento.id')
            ->select(
                'areas.*',
                'departamentos.nombre as nombrePuesto'
            )->where('areas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('areas.nombre', 'desc')->paginate(3);
        } else {
            $areas = Area::join('departamentos', 'areas.departamento_id', '=', 'departamento.id')
            ->select(
                'areas.*',
                'departamentos.nombre as nombrePuesto'
            )->where('areas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('areas.nombre', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $areas->total(),
                'current_page' => $areas->currentPage(),
                'per_page'     => $areas->perPage(),
                'last_page'    => $areas->lastPage(),
                'from'         => $areas->firstItem(),
                'to'           => $areas->lastItem(),
            ],
            'areas' => $areas
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $rules = [
                  'nombre' => 'required|unique:areas|max:50'
            ];
        $messages = [
                'nombre.unique' => 'Ya se registro  con el :attribute que ingresó.',
            ];
        $this->validate($request, $rules, $messages);
        try {
            if (!$request->ajax()) {
                return redirect('/');
            }
            
            $area = new Area();
            $area->nombre = $request->nombre;
            $area->descripcion = $request->descripcion;
            $area->area_id=(int) ($request->area_id);
            $area->save();

        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }

    public function selectArea(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
 
        $filtro = $request->filtro;
        if ($filtro=='') {
            $areas = Area::where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        } else {
            $areas = Area::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->orderBy('nombre', 'asc')->get();
        }
       
        
        return ['areas' => $areas];
    }

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
            $area = Area::findOrFail($request->id);
            $area->nombre = $request->nombre;
            $area->descripcion = $request->descripcion;
            $area->area_id=(int) ($request->area_id);

            $area->save();
        } catch (Exception $e) {
            return redirect()->withErrors('Error');
        }
    }
    
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $area = Area::findOrFail($request->id);
        $area->condicion = '0';
        $area->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }
        $area = Area::findOrFail($request->id);
        $area->condicion = '1';
        $area->save();
    }

}
