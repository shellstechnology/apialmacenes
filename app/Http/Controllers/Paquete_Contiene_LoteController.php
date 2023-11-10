<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Lote;
use App\Models\Paquete;
use App\Models\Paquete_Contiene_Lote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Paquete_Contiene_LoteController extends Controller
{
    public function MostrarTodosLosLotes(Request $Request)
    {
        $datosPaqueteContieneLote = Paquete_Contiene_Lote::withTrashed()->get();
        $infoPaqueteContieneLote = [];
        $idAlmacen = [];
        $idPaquete = [];
        $idLote = [];
        foreach ($datosPaqueteContieneLote as $paqueteContieneLote) {
            $infoPaqueteContieneLote[] = $this->obtenerPaquete($paqueteContieneLote);
        }
        $lugarAlmacen = Almacenes::withoutTrashed()->get();
        foreach ($lugarAlmacen as $datoLugar) {
            $idAlmacen[] = $datoLugar['id'];
        }
        $paquete = Paquete::withoutTrashed()->get();
        foreach ($paquete as $datoPaquete) {
            $idPaquete[] = $datoPaquete['id'];
        }
        $lote = Lote::withoutTrashed()->get();
        foreach ($lote as $datoLote) {
            $idLote[] = $datoLote['id'];
        }
        return [$infoPaqueteContieneLote,$idAlmacen,$idPaquete,$idLote];
    }

    private function obtenerPaquete($paqueteContieneLote)
    {
        try {
            $datosPaquete = Paquete::withTrashed()->where('id', $paqueteContieneLote['id_paquete'])->first();
            $infoPaquete = [
                'Id Paquete' => $datosPaquete['id'],
                'Lote' => $paqueteContieneLote['id_lote'],
                'Volumen(L)' => $datosPaquete['volumen_l'],
                'Peso(Kg)' => $datosPaquete['peso_kg'],
                'Almacen' => $paqueteContieneLote['id_almacen'],
                'created_at' => $paqueteContieneLote['created_at'],
                'updated_at' => $paqueteContieneLote['updated_at'],
                'deleted_at' => $paqueteContieneLote['deleted_at']
            ];
            return $infoPaquete;
        } catch (\Exception $e) {
            $mensajeDeError = 'Error:no se pudo obtener los datos de un paquete ';
        }
    }

    public function MostrarUnLote(Request $request, $id)
    {
        return Paquete_Contiene_Lote::where('id_lote', '=', $id)->get();
    }

    public function ComprobarDatosLote(Request $request)
    {   
        $validacion = $this->validacion($request->all());

        if ($validacion->fails())
            return ["errors" => $validacion->errors()];

        return $this->IngresarUnPaqueteAUnLote($request);
    }

    private function validacion($data)
    {
        return Validator::make(
            $data,
            [
                'id_lote' => 'required|numeric',
                'id_paquete' => 'required|numeric',
                'id_almacen' => 'required|numeric'
            ],
        );
    }

    public function IngresarUnPaqueteAUnLote(Request $request)
    {
        
        $Lote = new Paquete_Contiene_Lote;
        if (
            $request->post("id_lote") == null ||
            $request->post("id_paquete") == null

        ) return abort(403);

        $Lote->id_lote = $request->post("id_lote");
        $Lote->id_paquete = $request->post("id_paquete");
        $Lote->id_almacen = $request->post("id_almacen");
        $Lote->save();

        return $Lote;
    }


    public function Eliminar(Request $request, $id)
    {
        $Lote = Paquete_Contiene_Lote::where('id_paquete', '=', $id)->get();
        foreach ($Lote as $l) {
            $l->delete();
        }

        return ["mensaje" => "Lote $id eliminado."];
    }

    public function Modificar(Request $request, $id)
    {
        $Lote=Paquete_Contiene_Lote::where('id_paquete', $id)->update([
            'id_lote' => $request->post('id_lote'),
            'id_paquete' => $request->post('id_paquete'),
            'id_almacen' => $request->post('id_almacen'),
        ]);
        return $Lote;
    }

    public function restore($id)
    {
        $Lote =  Paquete_Contiene_Lote::withTrashed()->find($id)->restore();
        foreach ($Lote as $l) {
            $l->restore();
        }

    }
}
