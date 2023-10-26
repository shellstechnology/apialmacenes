<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Paquete;
use Tests\TestCase;

class PaqueteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function test_ListarUnPaqueteQueExiste(){
        $estructuraDelJson = [
            "id",
            "nombre",
            "volumen_l",
            "peso_kg",
            "id_estado_p",
            "id_caracteristica_paquete",
            "id_producto",
            "id_lugar_entrega",
            "nombre_destinatario",
            "nombre_remitente",
            "fecha_de_entrega",
            "created_at",
            "updated_at",
            "deleted_at"];
            $response = $this->get('/api/paquete/47');
            $response->assertStatus(200); // Valida el status HTTP de la peticion
            $response->assertJsonCount(14); // Valida que el JSON de respuesta tenga 12 campos
            $response->assertJsonStructure($estructuraDelJson); // Valida que la estructura de JSON tenga los campos especificados en el array
            $response->assertJsonFragment([
                "nombre" => "proyecto2023",
                "id" => 47,
                "nombre_remitente" => "shells tech tambien"
            ]); // Valida que los campos del JSON tengan esos valores puntuales
     }

     public function test_ListarUnoQueNoExiste()
     {
         $response = $this->get('/api/paquete/99999999999999');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }
     
     public function test_EliminarUnPaqueteQueNoExiste()
     {
         $response = $this->delete('/api/paquete/1000000');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }

     public function test_EliminarUnPaqueteQueExiste()
     {
         $response = $this->delete('/api/paquete/74');
         $response->assertStatus(200);
         $response->assertJsonFragment(["mensaje" => "Paquete 74 eliminado."]); // Valida que la estructura de JSON tenga los campos especificados en el array
         $this->assertDatabaseMissing("paquetes",[
             "id" => 74,
             "deleted_at" => null
         ]);
 
         Paquete::withTrashed()->where("id",74)->restore();

 
     }

     public function test_ModificarUnPaqueteQueExiste(){
        $estructura = [
            "id",
            "nombre",
            "volumen_l",
            "peso_kg",
            "id_estado_p",
            "id_caracteristica_paquete",
            "id_producto",
            "id_lugar_entrega",
            "nombre_destinatario",
            "nombre_remitente",
            "fecha_de_entrega",
            "created_at",
            "updated_at",
            "deleted_at"];

            $response = $this->put('/api/paquete/42', [
                "nombre" => "paquete modifica2",
                "volumen_l" => "40",
                "peso_kg" => "90",
                "id_estado_p" =>"2",
                "id_caracteristica_paquete" => "4",
                "id_producto" => "47",
                "id_lugar_entrega" => "2",
                "nombre_destinatario" =>"Puppycachi",
                "nombre_remitente" => "Bee",
                "fecha_de_entrega"=> "2001-07-04"
            ]);
            $response->assertStatus(200);
            $response->assertJsonStructure($estructura); // Valida que la estructura de JSON tenga los campos especificados en el array
            $response->assertJsonFragment(["nombre" => "paquete modifica2",
            "nombre_destinatario" =>"Puppycachi"
        ]);
     }

    }
