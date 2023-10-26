<?php

namespace App\Http\Controllers;

use App\Models\Paquete_Contiene_Lote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Paquete_Contiene_LoteController extends Controller
{
    public function MostrarTodosLosLotes(Request $Request)
    {
        return Paquete_Contiene_Lote::all();
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
                'id_paquete' => 'required|numeric|unique:paquetes',
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
        $Lote->id = $request->post("id_lote");
        $Lote->lote_id_paquete = $request->post("id_paquete");
        $Lote->id_almacen = $request->post("id_almacen");

        $Lote->save();

        return $Lote;
    }


    public function Eliminar(Request $request, $id)
    {
        $Lote = Paquete_Contiene_Lote::where('id_lote', '=', $id)->get();
        foreach ($Lote as $l) {
            $l->delete();
        }

        return ["mensaje" => "Lote $id eliminado."];
    }

    public function Modificar(Request $request, $id)
    {
        $Lote = Paquete_Contiene_Lote::where('id_paquete', '=', $id)->get();

        foreach ($Lote as $l) {
            $l->id_lote = $request->post("id_lote");
            $l->id_paquete = $request->post("id_paquete");
            $l->id_almacen = $request->post("id_almacen");
            $l->save();
        }
        return $l;
    }

    public function restore($id)
    {
        Paquete_Contiene_Lote::withTrashed()->find($id)->restore();

        return back();
    }
}
