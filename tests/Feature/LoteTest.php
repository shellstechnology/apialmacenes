<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lote;

class LoteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_agregarUnLote(){

        $response = $this->post('/api/lote',[
            "volumen_l" => "0"
        ]);
        $response->assertStatus(201);
        $ultimoLote = Lote::latest('created_at')->first();
        $idLote = $ultimoLote['id'];
        $this->assertDatabaseHas('lotes', [
            'id' => $idLote,

        ]);
        
       Lote::withTrashed()->where('id',$idLote)->forceDelete();
       }

       public function test_EliminarUnLote(){
        $response = $this->delete('/api/lote/74',[
            "id" => "74",
        ]);
        $response->assertStatus(200);
       Lote::withTrashed()->where("id",74)->restore();
       }


       public function test_RecuperarUnLote(){
        //elimino el lote
        $response1 = $this->delete('api/lote/74',[
            "id" => "74",
        ]);
        $response1->assertStatus(200);
    
        //recupero el lote
        $response2 = $this->patch('api/lote/74');
      $response2->assertStatus(200);
       }
}