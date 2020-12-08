<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\CompetenciaEmpleado;
use App\ContactoEmergencia;
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
            
            /*$empleados = Empleado::join('competencias_empleados','empleados.id','=','competencias_empleados.empleado_id')
            //->join('competencias','competencias_empleados.competencia_id','=','competencias.id')
            ->select('cuil', 'direccion', 'empleados.nombre as nombreEmpleado',
             'empleados.apellido as apellidoEmpleado', 'fechaAlta', 'fechaBaja',
              'curriculum', 'fechaNacimiento', 'empleados.condicion as condicion', '')
              ->orderBy('empleados.nombre', 'desc')->paginate(3);*/
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
                    $exploded = explode(',', $request->curriculum);
                    $decoded = base64_decode($exploded[1]);
                    if(str_contains($exploded[0], 'pdf'))
                        $extension = 'pdf';
                    else
                        $extension = 'pdf';
                    $fileName = str_random().'.'.$extension;
                    $path = public_path().'/'.$fileName;
                    file_put_contents($path, $decoded);
                   

                    $empleado = new Empleado();
                    $empleado->nombre = $request->nombre;
                    $empleado->apellido = $request->apellido;
                    $empleado->cuil = $request->cuil;
                    $empleado->fechaNacimiento = $request->fechaNacimiento;
                    $empleado->fechaAlta = $request->fechaAlta;
                    $empleado->direccion = $request->direccion;
                    //$empleado->curriculum = $request->curriculum;
                    $empleado->curriculum = $fileName;
                    $empleado->save();
                    $competencias = $request->data;//Array de competencias
                    $contactos = $request->contactos;//Array de contactos
                    //Recorro todos los elementos
        
                    foreach($competencias as $ep=>$det)
                    {
                        $competencia = new CompetenciaEmpleado();
                        $competencia->empleado_id = $empleado->id;
                        $competencia->competencia_id = $det['id'];
                        $competencia->save();
                    }
                    foreach($contactos as $ep=>$det)
                    {
                        $contacto = new ContactoEmergencia();
                        $contacto->empleado_id = $empleado->id;
                        $contacto->nombre = $det['nombre'];
                        $contacto->telefono1 = $det['tel1'];
                        $contacto->telefono2 = $det['tel2'];
                        $contacto->correo = "este es un correo";
                        $contacto->save();
                    }       
                } catch (Exception $e){
                    //return redirect()->withErrors('Error');
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
                DB::beginTransaction();  
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
            
            $competencias = $request->data;//Array de competencias
            $contactos = $request->contactos;//Array de contactos
            
            //Recorro todos los elementos
            $idempleado = $request->id;    
                    /*foreach($competencias as $ep=>$det)
                    {
                        $idcompetencia = $det['id'];
                        if($this->encontrarEliminar($idempleado, $idcompetencia)==1){
                                $competencia = new CompetenciaEmpleado();
                                $competencia->empleado_id = $empleado->id;
                                $competencia->competencia_id = $det['id'];
                                $competencia->save();
                        }
                                
                    }*/
                    foreach($contactos as $ep=>$det)
                    {
                        
                        if (!empty($det['id'])){
                            $idcontacto = $det['id'];
                            $contacto = ContactoEmergencia::findOrFail($idcontacto);
                            $contacto->nombre = $det['nombre'];
                            $contacto->telefono1 = $det['telefono1'];
                            $contacto->telefono2 = $det['telefono2'];
                            $contacto->correo = $det['correo'];
                            $contacto->save();
                        } else{
                            $contacto = new ContactoEmergencia();
                            $contacto->empleado_id = $empleado->id;
                            $contacto->nombre = $det['nombre'];
                            $contacto->telefono1 = $det['telefono1'];
                            $contacto->telefono2 = $det['telefono2'];
                            $contacto->correo = $det['correo'];
                            $contacto->save();
                        }
                        
                    }   
                        
                    DB::commit();
        } catch (PDOException $e){
            //return redirect()->withErrors('Error');
            return 'error' + $e;
            DB::rollBack();
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
    public function findCompetencias(Request $request)
    {
       $id = $request->id;
        $competencias = CompetenciaEmpleado::join('competencias','competencias_empleados.competencia_id','=','competencias.id')
        ->join('empleados','competencias_empleados.empleado_id','=','empleados.id')
        ->select('competencias.id as id', 'competencias.nombre as nombre')
        ->where('empleados.id', '=', $id)
        ->orderBy('competencias.nombre', 'asc')->get();
        
        return ['competencias' => $competencias];
    }
    public function findContactos(Request $request)
    {
       $id = $request->id;
        $contactos = ContactoEmergencia::join('empleados','contactos_emergencias.empleado_id','=','empleados.id')
        ->select('contactos_emergencias.id as id', 'contactos_emergencias.nombre as nombre', 'telefono1', 'telefono2', 'correo')
        ->where('empleados.id', '=', $id)
        ->orderBy('contactos_emergencias.nombre', 'asc')->get();
        
        return ['contactos' => $contactos];
    }
    public function encontrar($idempleado, $idcompetencia)
    {
        
        $comp = CompetenciaEmpleado::where('empleado_id', '=', $idempleado)
        ->where('competencia_id', '=', $idcompetencia)
        ->select('id')->get();
        if (count($comp)==0){
            return '1';
        } else{
            return '0';
        }
    }
   
}
