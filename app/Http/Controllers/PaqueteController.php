<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\Paquete;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Lugares_Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaqueteController extends Controller
{

    public function MostrarTodosLosPaquetes(Request $Request)
    {
        try{
            $datoProducto = Producto::withTrashed()->get();
            $infoProducto = [];
            $infoMonedas = [];
            if ($datoProducto) {
                foreach ($datoProducto as $dato) {
                    $infoProducto[] = $this->obtenerProducto($dato);
                }
            }
            // $infoMonedas = $this->obtenerMonedas();
            // Session::put('monedas', $infoMonedas);
            return $infoProducto;
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            return $mensajeDeError;
        }
    }
    private function obtenerProducto($producto)
    {
        try {
            $moneda = Moneda::withTrashed()->where('id', $producto['id_moneda'])->first();
            return ([
                'Id' => $producto['id'],
                'Nombre' => $producto['nombre'],
                'Stock' => $producto['stock'],
                'Precio' => $producto['precio'],
                'Moneda' => $moneda['moneda'],
                'created_at' => $producto['created_at'],
                'updated_at' => $producto['updated_at'],
                'deleted_at' => $producto['deleted_at']
            ]);
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            return $mensajeDeError;
        }

    }


    public function MostrarMiPaquete(Request $request, $idPaquete)
    {
        return Paquete::findOrFail($idPaquete);
    }

    public function ComprobarDatosPaqueteAIngresar(Request $request)
    {
        $validacion = $this->validacion($request->all());
        if ($validacion->fails())
            return ["errors" => $validacion->errors()];
        return $this->IngresarUnPaqueteConDireccion($request);
    }

    public function ComprobarDatosPaqueteAModificar(Request $request)
    {
        $validacion = $this->validacion($request->all());
        if ($validacion->fails())
            return ["errors" => $validacion->errors()];
        return $this->ModificarUnPaqueteConDireccion($request);
    }

    private function validacion($data)
    {
        return Validator::make(
            $data,
            [
                'nombre' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:50|min:5',
                'volumen_l' => 'required|numeric|max:1000|min:1',
                'peso_kg' => 'required|numeric|max:1000|min:1',
                'id_estado_p' => 'required|numeric',
                'id_caracteristica_paquete' => 'required|numeric',
                'id_producto' => 'required|numeric',
                'nombre_destinatario' => 'required|alpha|max:100|min:3',
                'nombre_remitente' => 'required|alpha|max:100|min:3',
                'direccion'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:100|min:1',
                'latitud'=>'required|numeric|max:200|min:-200',
                'longitud'=>'required|numeric|max:200|min:-200',
               

            ],
        );
    }

    public function IngresarUnPaqueteConDireccion(Request $request){
        $this -> lockTables();
        DB::beginTransaction();
        $this -> IngresarDireccion($request);
        $ultimaDireccion = Lugares_Entrega::latest('created_at')->first();
        $idUltimaDireccion = $ultimaDireccion['id'];
        $this -> IngresarUnpaquete($request,  $idUltimaDireccion);
        DB::commit();
        DB::raw('UNLOCK TABLES');
    }

    public function IngresarDireccion(Request $request){
        $lugarEntrega = new Lugares_Entrega;
        $lugarEntrega->latitud = $request->post("latitud");
        $lugarEntrega->longitud = $request->post("longitud");
        $lugarEntrega->direccion = $request->post("direccion");
        $lugarEntrega->save();
        return $lugarEntrega;
    }

    private function lockTables(){
        DB::raw('LOCK TABLE lugares_entrega WRITE');
        DB::raw('LOCK TABLE paquetes WRITE');
    }

    public function IngresarUnPaquete(Request $request, $idDireccion)
    {
        $Paquete = new Paquete;
        $Paquete->nombre = $request->post("nombre");
        $Paquete->volumen_l = $request->post("volumen_l");
        $Paquete->peso_kg = $request->post("peso_kg");
        $Paquete->id_estado_p = $request->post("id_estado_p");
        $Paquete->id_caracteristica_paquete = $request->post("id_caracteristica_paquete");
        $Paquete->id_producto = $request->post("id_producto");
        $Paquete->id_lugar_entrega = $idDireccion;
        $Paquete->nombre_destinatario = $request->post("nombre_destinatario");
        $Paquete->nombre_remitente = $request->post("nombre_remitente");

        $Paquete->save();

        return $Paquete;
    }


    public function Eliminar(Request $request, $idPaquete)
    {
        $Paquete = Paquete::findOrFail($idPaquete);
        $Paquete->delete();

        return ["mensaje" => "Paquete $idPaquete eliminado."];
    }

    public function Modificar(Request $request, $idPaquete)
    {
        $Paquete = Paquete::findOrFail($idPaquete);
        $Paquete->nombre = $request->post("nombre");
        $Paquete->volumen_l = $request->post("volumen_l");
        $Paquete->peso_kg = $request->post("peso_kg");
        $Paquete->id_estado_p = $request->post("id_estado_p");
        $Paquete->id_caracteristica_paquete = $request->post("id_caracteristica_paquete");
        $Paquete->id_producto = $request->post("id_producto");
        $Paquete->id_lugar_entrega = $request->post("id_lugar_entrega");
        $Paquete->nombre_destinatario = $request->post("nombre_destinatario");
        $Paquete->nombre_remitente = $request->post("nombre_remitente");
        $Paquete->fecha_de_entrega = $request->post("fecha_de_entrega");

        $Paquete->save();

        return $Paquete;
    }

    public function restore($id)
    {
        Paquete::withTrashed()->find($id)->restore();

        return back();
    }
}
