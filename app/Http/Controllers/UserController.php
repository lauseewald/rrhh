<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empresa;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $users = User::orderBy('users.id', 'desc')->paginate(3);
        }
        else{
            $users = User::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
 
        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users
        ];
        
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rules = [
            //'apellido' => 'required|max:255',
            //'nombre' => 'required|max:255',
            'usuario' => 'required|unique:users',
     
        ];
        $messages = [
            'usuario.unique' => 'Ese :attribute ya se encuentra en uso.',
          
        ];
        $this->validate($request, $rules, $messages);
        try{
          
            
            $iduser = \Auth::user()->id;
           
            $empresa = $this->obtenerEmpresa($iduser);
            $user = new User();
            $user->id = $request->id;
            $user->usuario = $request->usuario;
            $user->email = $request->email;
            $user->empresa_id = $empresa;
            $user->password = bcrypt($request->password);
              
 
            $user->save();
 
           
 
        } catch (PDOException $e){
            return 'error' + $e;
        }
 
         
         
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $us = $request->usuario;
        $ema = $request->email;
        if($us != $user->usuario && $ema != $user->email){
            $rules = [
           
                'usuario' => 'required|unique:users',
                'email' => 'required|unique:users',
                
            ];
            $messages = [
                'usuario.unique' => 'Ese nombre de :attribute ya fue utilizado.',
                'email.unique' => 'El :attribute que ingresó ya fue utilizado.',
               
            ];
            $this->validate($request, $rules, $messages);

        }
        if($us != $user->usuario){
            $rules = [
           
                'usuario' => 'required|unique:users',
                
                
            ];
            $messages = [
                'usuario.unique' => 'Ese nombre de :attribute ya fue utilizado.',
               
            ];
            $this->validate($request, $rules, $messages);

        }
        if($ema != $user->email){
            $rules = [
           
                'email' => 'required|unique:users',
                
            ];
            $messages = [
                
                'email.unique' => 'El email que ingresó ya fue utilizado.',
               
            ];
            $this->validate($request, $rules, $messages);

        }
            
        try{
            //$iduser = \Auth::user()->id;
           
            //$empresa = $this->obtenerEmpresa($iduser);
            $user->usuario = $request->usuario;
            $user->email = $request->email;
            $user->password = bcrypt( $request->password);
            //$user->empresa_id = $empresa;
            $user->condicion = '1';
            $user->save();
 
           
          
        } catch (PDOException $e){
            return 'error' + $e;
        } 
 
    }
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }

    public function obtenerEmpresa($iduser)
    {
        
        $empresa = Empresa::join('users','empresas.id','=','users.empresa_id')
        ->where('users.id', '=', $iduser)
        ->select('empresas.id as id')
        ->orderBy('empresas.id', 'asc')->take(1)->get();
        $empresa = $empresa[0]['id'];
        return $empresa;
    }
}
