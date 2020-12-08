<?php

namespace App\Http\Controllers;

use App\Competencia;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    //

    public function selectCompetencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        if ($filtro==''){
            $competencias = Competencia::where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
            
        } else {
            $competencias = Competencia::where('nombre', 'like', '%'. $filtro . '%')
            ->where('condicion', '=', 1)
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
        }
        
        return ['competencias' => $competencias];
    }
}
