<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoteTest extends TestCase
{
 
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListarUnLoteQueExiste(){
     
            $response = $this->get('/MostrarLote/47');
            $response->assertStatus(200); // Valida el status HTTP de la peticion
            $response->assertJsonCount(1); // Valida que el JSON de respuesta tenga 1 campo, tiene solo 1 porque toma como respuesta el contenido del array de lote, que en este caso solo tiene un paquete
            $response->assertJsonFragment([
                "id" => 47,
                "lote_id_paquete" => 47
                
            ]); 
     }

     public function test_EliminarUnLoteQueExiste()
     {
         $response = $this->delete('/EliminarLote/47');
         $response->assertStatus(200);
         $response->assertJsonFragment(["mensaje" => "Lote 47 eliminado."]); 
         $this->assertDatabaseMissing("Lote",[
             "id" => 47,
             "deleted_at" => null
         ]);
 
         Lote::withTrashed()->where("id",47)->restore();

 
     }
   
     public function test_ModificarUnLoteQueExiste(){
        $estructura = [
            "id",
            "lote_id_paquete",
            "created_at",
            "updated_at",
            "deleted_at"];

            $response = $this->put('/ModificarLote/47', [
                "id" => "99",
                "lote_id_paquete" => "1"
           
            ]);
            $response->assertStatus(200);
            $response->assertJsonStructure($estructura); 
            $response->assertJsonFragment(["id" => "99",
            "lote_id_paquete" =>"1"
        ]);
     }
}
