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
        $datoLote = Lote::withTrashed()->get();
        $infoLote = [];
        if ($datoLote) {
            foreach ($datoLote as $lote) {
                $infoLote[] = $this->obtenerDatosLotes($lote);
            }
            return $infoLote;
        }
    }

    private function obtenerDatosLotes($lote)
    {
            return ([
                'Id Lote' => $lote['id'],
                'Volumen(L)' => $lote['volumen_l'],
                'Peso(Kg)' => $lote['peso_kg'],
                'created_at' => $lote['created_at'],
                'updated_at' => $lote['updated_at'],
                'deleted_at' => $lote['deleted_at'],
            ]);
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
