<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaqueteController extends Controller
{

        public function MostrarTodosLosPaquetes(Request $Request){
         return Paquete::all();
        }
     

        public function MostrarMiPaquete(Request $request, $idPaquete){
            return Paquete::findOrFail($idPaquete);
    
        }
      
        public function IngresarUnPaquete(Request $request){
            $Paquete = new Paquete;
            if($request -> post("nombre")== null || 
            $request -> post("estado")== null  ||
            $request -> post("volumenEnL")== null ||
            $request -> post("pesoEnKg")== null ||
            $request -> post("tipoDePaquete")== null ||
            $request -> post("nombreDelDestinatario")== null ||
            $request -> post("nombreDelRemitente")== null ||
            $request -> post("fechaDeEntrega")== null 
              )
                return abort(403);
            $Paquete -> nombre = $request -> post("nombre");
            $Paquete -> estado = $request -> post("estado");
            $Paquete -> volumen_l = $request -> post("volumenEnL");
            $Paquete -> peso_kg = $request -> post("pesoEnKg");
            $Paquete -> tipo_Paquete = $request -> post("tipoDePaquete");
            $Paquete -> nombre_del_destinatario = $request -> post("nombreDelDestinatario");
            $Paquete -> nombre_del_remitente = $request -> post("nombreDelRemitente");
            $Paquete -> fecha_de_entrega = $request -> post("fechaDeEntrega");
    
            $Paquete -> save();
    
            return $Paquete;
        }


        public function Eliminar(Request $request, $idPaquete){
            $Paquete = Paquete::findOrFail($idPaquete);
            $Paquete -> delete();
    
            return [ "mensaje" => "Paquete $idPaquete eliminado."];
    
        }

        public function Modificar(Request $request, $idPaquete){
            $Paquete = Paquete::findOrFail($idPaquete);
            $Paquete -> nombre = $request -> post("nombre");
            $Paquete -> estado = $request -> post("estado");
            $Paquete -> volumen_l = $request -> post("volumen_l");
            $Paquete -> peso_kg = $request -> post("peso_kg");
            $Paquete -> tipo_Paquete = $request -> post("tipo_paquete");
            $Paquete -> nombre_del_destinatario = $request -> post("nombre_del_destinatario");
            $Paquete -> nombre_del_remitente = $request -> post("nombre_del_remitente");
            $Paquete -> fecha_de_entrega = $request -> post("fecha_de_entrega");
    
            $Paquete -> save();
    
            return $Paquete;
    
        }

        public function restore($id)
        {
            Paquete::withTrashed()->find($id)->restore();
      
            return back();
        }  
    }