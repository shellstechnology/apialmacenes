<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Camion_Lleva_Lote;

class Camion_Lleva_LoteController extends Controller
{
    public function MostrarTodosLosCamionesConLotes(Request $Request)
    {
        return Camion_Lleva_Lote::all();
    }

    public function MostrarUnCamionConSusLotes(Request $request, $matricula)
    {
        return Camion_Lleva_Lote::findOrFail($matricula);
    }

    public function IngresarUnLoteAUnCamion(Request $request)
    {
        $CamionLlevaLote = new Camion_Lleva_Lote;
        $CamionLlevaLote->matricula  = $request->post("matricula");
        $CamionLlevaLote->id_lote = $request->post("id_lote");

        $CamionLlevaLote->save();

        return $CamionLlevaLote;
    }

    public function ModificarUnLoteEnUnCamion(Request $request, $idLote)
    {
        $CamionLlevaLote = Camion_Lleva_Lote::findOrFail($idLote);
        $CamionLlevaLote->matricula  = $request->post("matricula");
        $CamionLlevaLote->id_lote = $request->post("id_lote");

        $CamionLlevaLote->save();

        return $CamionLlevaLote;
    }

    
    public function Eliminar(Request $request, $idLote)
    {
        $CamionLlevaLote = Camion_Lleva_Lote::findOrFail($idLote);
        $CamionLlevaLote->delete();

        return ["mensaje" => "Lote $idLote eliminado."];
    }

    public function restore($id)
    {
        Paquete::withTrashed()->find($id)->restore();

        return back();
    }
}
