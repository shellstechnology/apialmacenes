<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Camiones;
use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\Camion_Lleva_Lote;

class Camion_Lleva_LoteController extends Controller
{
    public function MostrarTodosLosCamionesConLotes(Request $Request)
    {
        $datosCamionLlevaLote = Camion_Lleva_Lote::withTrashed()->get();
        $infoCamionLlevaLote = [];
        $matriculaCamion = [];
        $idLote = [];
        foreach ($datosCamionLlevaLote as $camionLlevaLote) {
            $infoCamionLlevaLote[] = $this->obtenerCamionLlevaLote($camionLlevaLote);
        }
        $camiones = Camiones::withoutTrashed()->get();
        foreach ($camiones as $camion) {
            $matriculaCamion[] = $camion['matricula'];
        }
        $lote = Lote::withoutTrashed()->get();
        foreach ($lote as $datoLote) {
            $idLote[] = $datoLote['id'];
        }
        return [$infoCamionLlevaLote,$matriculaCamion,$idLote];
    }

    
    private function obtenerCamionLlevaLote($camionLlevaLote)
    {
        $infoCamionLlevaLote = [
            'Id Lote' => $camionLlevaLote['id_lote'],
            'Matricula Camion' => $camionLlevaLote['matricula'],
            'created_at' => $camionLlevaLote['created_at'],
            'updated_at' => $camionLlevaLote['updated_at'],
            'deleted_at' => $camionLlevaLote['deleted_at']
        ];
        return $infoCamionLlevaLote;
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
        Camion_Lleva_Lote::withTrashed()->find($id)->restore();
    }
}
