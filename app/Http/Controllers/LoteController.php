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
    

       public function MostrarUnLote(Request $request, $id){
       return Lote::where('id', '=', $id)->get();
    
       }
     
       public function IngresarUnLote(Request $request){
           $Lote = new Lote;
           if($request -> post("id")== null || 
           $request -> post("lote_id_paquete")== null  
       
             )
               return abort(403);
           $Lote -> id = $request -> post("id");
           $Lote -> lote_id_paquete = $request -> post("lote_id_paquete");

           $Lote -> save();
   
           return $Lote;
       }


       public function Eliminar(Request $request, $id){
           $Lote = Lote::where('id', '=', $id)->get();
          foreach ($Lote as $l){
            $l -> delete();
          }
   
           return [ "mensaje" => "Lote $idLote eliminado."];
   
       }

       public function Modificar(Request $request, $id){
           $Lote = Lote::where('id', '=', $id)->get();
      
        foreach($Lote as $l){
            $l -> id = $request -> post("id");
            $l -> lote_id_paquete = $request -> post("lote_id_paquete");
           $l -> save();
                  }
           return $l;
   
       }

       public function restore($id)
       {
           Lote::withTrashed()->find($id)->restore();
     
           return back();
       }  
}
