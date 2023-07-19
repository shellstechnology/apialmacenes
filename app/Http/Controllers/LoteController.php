<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function MostrarTodosLosLotes(Request $Request){
        return Lote::all();
       }
    

       public function MostrarUnLote(Request $request, $idLote){
           return Lote::findOrFail($idLote);
   
       }
     
       public function IngresarUnLote(Request $request){
           $Lote
            = new Lote;
           if($request -> post("id")== null || 
           $request -> post("id_paquete")== null  
       
             )
               return abort(403);
           $Lote -> id = $request -> post("id");
           $Lote -> id_paquete = $request -> post("id_paquete");

           $Paquete -> save();
   
           return $Paquete;
       }


       public function Eliminar(Request $request, $idLote){
           $Lote = Lote::findOrFail($idLote);
           $Lote -> delete();
   
           return [ "mensaje" => "Lote $idLote eliminado."];
   
       }

       public function Modificar(Request $request, $idLote){
           $Lote = Paquete::findOrFail($idLote);
           $Lote -> id = $request -> post("id");
           $Lote -> id_paquete = $request -> post("id_paquete");
    
           $Lote -> save();
   
           return $Lote;
   
       }
}
