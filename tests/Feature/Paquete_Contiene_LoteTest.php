<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Paquete_Contiene_Lote;
use Tests\TestCase;


class Paquete_Contiene_LoteTest extends TestCase
{
 
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListarUnLoteQueExiste(){
     
            $response = $this->get('api/paquete-lote/47');
            $response->assertStatus(200); // Valida el status HTTP de la peticion
            $response->assertJsonCount(1); // Valida que el JSON de respuesta tenga 1 campo (es solo 1 porque devuelve 1 array)
            $response->assertJsonFragment([
                "id_lote" => 47,
                "id_paquete" => 47
                
            ]); 
     }

     
     public function test_ModificarUnLoteQueExiste(){
         $estructura = [
             "id_lote",
             "id_paquete",
             "id_almacen",
             "created_at",
             "updated_at",
             "deleted_at"];
             
             $response = $this->put('api/paquete-lote/42', [
                 "id_lote" => "42",
                 "id_paquete" => "42",
                 "id_almacen"=> "47"
                ]);
                $response->assertStatus(200);
                $response->assertJsonStructure($estructura); 
                $response->assertJsonFragment(["id_lote" => "42",
                "id_paquete" =>"42"
            ]);
        }
        public function test_EliminarUnLoteQueExiste()
        {
            $response = $this->delete('api/paquete-lote/74');
            $response->assertStatus(200);
            $response->assertJsonFragment(["mensaje" => "Lote 74 eliminado."]); 
            $this->assertDatabaseMissing("paquete_contiene_lote",[
                "id_lote" => 74,
                "deleted_at" => null
            ]);
    
            Paquete_Contiene_Lote::withTrashed()->where("id_lote",74)->restore();
        }
    }
