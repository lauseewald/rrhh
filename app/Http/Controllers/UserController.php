<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'name' => 'required|unique:users',
     
        ];
        $messages = [
            'name.unique' => 'Ese :attribute ya se encuentra en uso.',
          
        ];
        $this->validate($request, $rules, $messages);
        try{
            DB::beginTransaction();
            
 
            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            //$user->condicion = '1';         
 
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
 
         
         
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $us = $request->name;
        $ema = $request->email;
        if($us != $user->name && $ema != $user->email){
            $rules = [
           
                'name' => 'required|unique:users',
                'email' => 'required|unique:users',
                
            ];
            $messages = [
                'name.unique' => 'Ese nombre de :attribute ya fue utilizado.',
                'email.unique' => 'El :attribute que ingresó ya fue utilizado.',
               
            ];
            $this->validate($request, $rules, $messages);

        }
        if($us != $user->name){
            $rules = [
           
                'name' => 'required|unique:users',
                
                
            ];
            $messages = [
                'name.unique' => 'Ese nombre de :attribute ya fue utilizado.',
               
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
            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt( $request->password);
            //$user->condicion = '1';
            $user->save();
 
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
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
}
