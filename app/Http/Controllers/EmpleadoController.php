<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\CompetenciaEmpleado;
use Exception;
use Illuminate\Support\Facades\DB;
class EmpleadoController extends Controller
{
   
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            
            $empleados = Empleado::orderBy('nombre', 'desc')->paginate(3);
        }
        else{
           
            $empleados = Empleado::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('nombre', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados' => $empleados
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
       
           $rules = [
                'apellido' => 'required|max:100',
                'nombre' => 'required|max:100',
                'cuil' => 'required|unique:empleados|max:11'
                
            ];
            $messages = [
                'cuil.unique' => 'Ya se registro un empleado con el :attribute que ingresó.',
            
            ];
            $this->validate($request, $rules, $messages);
            //$cuit = $request->cuil;
            //$this->validarCUIT($cuit);
            
                try{
                    if (!$request->ajax()) return redirect('/');
                    /*$exploded = explode(',', $request->image);
                    $decoded = base64_decode($exploded[1]);
                    if(str_contains($exploded[0], 'jpeg'))
                        $extension = 'jpg';
                    else
                        $extension = 'png';
                    $fileName = str_random().'.'.$extension;
                    $path = public_path().'/'.$fileName;
                    file_put_contents($path, $decoded);*/
                   

                    $empleado = new Empleado();
                    $empleado->nombre = $request->nombre;
                    $empleado->apellido = $request->apellido;
                    $empleado->cuil = $request->cuil;
                    $empleado->fechaNacimiento = $request->fechaNacimiento;
                    $empleado->fechaAlta = $request->fechaAlta;
                    $empleado->direccion = $request->direccion;
                    $empleado->curriculum = $request->curriculum;
                    //$empleado->curriculum = $fileName;
                    $empleado->save();
                    $competencias = $request->data;//Array de competencias
                    //Recorro todos los elementos
        
                    foreach($competencias as $ep=>$det)
                    {
                        $competencia = new CompetenciaEmpleado();
                        $competencia->idempleado = $empleado->id;
                        $competencia->competencia_id = $det['competencia_id'];
                        $competencia->save();
                    }    
                } catch (Exception $e){
                    return redirect()->withErrors('Error');
                }
               
    }

    public function selectEmpleado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        if ($filtro==''){
            $empleados = Empleado::where('condicion', '=', 1)
            // ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
            
        } else {
            $empleados = Empleado::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            // ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
        }
        
        return ['empleados' => $empleados];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
            $rules = [
                'apellido' => 'required|max:100',
                'nombre' => 'required|max:100',
                'cuil' => 'required|max:11'
                
            ];
            $messages = [
                'nombre.required' => 'Debe ingresar el :attribute .',
                'apellido.required' => 'Debe ingresar el :attribute .',
            
            ];
            $this->validate($request, $rules, $messages);
            try{
                if (!$request->ajax()) return redirect('/');
            $empleado = Empleado::findOrFail($request->id);
            $empleado->nombre = $request->nombre;
            $empleado->apellido = $request->apellido;
            //$empleado->id = $request->id;
            $empleado->fechaAlta = $request->fechaAlta;
            $empleado->fechaNacimiento = $request->fechaNacimiento;
            $empleado->direccion = $request->direccion;
            $empleado->curriculum = $request->curriculum;
            $empleado->cuil = $request->cuil;
            $empleado->condicion = '1';
            $empleado->save();
            
            
        } catch (Exception $e){
            //return redirect()->withErrors('Error');
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->condicion = '0';
        $empleado->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->condicion = '1';
        $empleado->save();
    }
   
}
