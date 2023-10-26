<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
use Illuminate\Support\Facades\Validator;

class LoteController extends Controller
{

    public function MostrarTodosLosLotes(Request $Request)
    {
        return Lote::all();
    }

    public function MostrarUnLote(Request $request, $idLote)
    {
        return Lote::findOrFail($idLote);
    }

    public function IngresarUnLote(Request $request)
    {
        $Lote = new Lote;
        $Lote->volumen_l = 0;
        $Lote->peso_kg = 0;
        $Lote->save();

        return $Lote;
    }
   
    public function Eliminar(Request $request, $id)
    {
        $Lote = Lote::where('id', '=', $id)->get();
        foreach ($Lote as $l) {
            $l->delete();
        }

        return ["mensaje" => "Lote $id eliminado."];
    }

    public function Recuperar(Request $request, $id)
    {
        $lote = Lote::onlyTrashed()->find($id);
        if ($lote) {
            Lote::where('id', $id)->restore();
        }
    }
  
}
