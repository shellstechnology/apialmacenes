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
            "estado",
            "volumen_l",
            "peso_kg",
            "tipo_paquete",
            "nombre_del_destinatario",
            "nombre_del_remitente",
            "fecha_de_entrega",
            "created_at",
            "updated_at",
            "deleted_at"];
            $response = $this->get('/MostrarPaquete/47');
            $response->assertStatus(200); // Valida el status HTTP de la peticion
            $response->assertJsonCount(12); // Valida que el JSON de respuesta tenga 12 campos
            $response->assertJsonStructure($estructuraDelJson); // Valida que la estructura de JSON tenga los campos especificados en el array
            $response->assertJsonFragment([
                "nombre" => "quesos cremosos",
                "id" => 47,
                "nombre_del_remitente" => "vegetta777"
            ]); // Valida que los campos del JSON tengan esos valores puntuales
     }

     public function test_ListarUnoQueNoExiste()
     {
         $response = $this->get('/MostrarPaquete?idPaquete=99999999999999');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }
     
     public function test_EliminarUnPaqueteQueNoExiste()
     {
         $response = $this->delete('/eliminar/1000000');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }

     public function test_EliminarUnPaqueteQueExiste()
     {
         $response = $this->delete('/eliminar/47');
         $response->assertStatus(200);
         $response->assertJsonFragment(["mensaje" => "Paquete 47 eliminado."]); // Valida que la estructura de JSON tenga los campos especificados en el array
         $this->assertDatabaseMissing("paquete",[
             "id" => 47,
             "deleted_at" => null
         ]);
 
         Paquete::withTrashed()->where("id",47)->restore();

 
     }


    }
