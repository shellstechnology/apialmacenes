<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Producto;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_ListarUnProductoQueExiste(){
        $estructuraDelJson = [
            "nombre",
            "precio",
            "stock",
            "id_moneda",
            "created_at",
            "updated_at",
            "deleted_at"];
            $response = $this->get('/api/producto/47');
            $response->assertStatus(200); // Valida el status HTTP de la peticion
            $response->assertJsonCount(8); // Valida que el JSON de respuesta tenga 8 campos
            $response->assertJsonStructure($estructuraDelJson); // Valida que la estructura de JSON tenga los campos especificados en el array
            $response->assertJsonFragment([
                "nombre" => "Proyecto2023",
                "id" => 47,
            ]); // Valida que los campos del JSON tengan esos valores puntuales
     }

     public function test_ListarUnProductoQueNoExiste()
     {
         $response = $this->get('/api/producto/99999999999999');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }

     public function test_EliminarUnProductoQueNoExiste()
     {
         $response = $this->delete('/api/producto/1000000123');
         $response->assertStatus(404); // Valida el status HTTP de la peticion
     }

     public function test_EliminarUnProductoQueExiste()
     {
         $response = $this->delete('/api/producto/74');
         $response->assertStatus(200);
         $response->assertJsonFragment(["mensaje" => "Producto 74 eliminado."]); // Valida que la estructura de JSON tenga los campos especificados en el array
         $this->assertDatabaseMissing("productos",[
             "id" => 74,
             "deleted_at" => null
         ]);
 
         Producto::withTrashed()->where("id",74)->restore();
 
     }

     public function test_ModificarUnPaqueteQueExiste(){
        $estructura = [
            "nombre",
            "precio",
            "stock",
            "id_moneda",
            "created_at",
            "updated_at",
            "deleted_at"];

            $response = $this->put('/api/producto/42', [
                "nombre" => "proyecto hector",
                "precio" => "9999",
                "stock" => "1",
                "idMoneda" =>"1",
            ]);
            $response->assertStatus(200);
            $response->assertJsonStructure($estructura); // Valida la estructura de JSON 
            $response->assertJsonFragment(["nombre" => "proyecto hector",
            "precio" => "9999"
        ]);
     }
}
