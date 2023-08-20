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
       return Lote::where('id_lote', '=', $id)->get();
    
       }
     
       public function IngresarUnLote(Request $request){
           $Lote = new Lote;
           if($request -> post("id_lote")== null || 
           $request -> post("id_paquete")== null  
       
             )
               return abort(403);
           $Lote -> id = $request -> post("id_lote");
           $Lote -> lote_id_paquete = $request -> post("id_paquete");

           $Lote -> save();
   
           return $Lote;
       }


       public function Eliminar(Request $request, $id){
           $Lote = Lote::where('id_lote', '=', $id)->get();
          foreach ($Lote as $l){
            $l -> delete();
          }
   
           return [ "mensaje" => "Lote $id eliminado."];
   
       }

       public function Modificar(Request $request, $id){
           $Lote = Lote::where('id_paquete', '=', $id)->get();
      
        foreach($Lote as $l){
            $l -> id_lote = $request -> post("id_lote");
            $l -> id_paquete = $request -> post("id_paquete");
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
