<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\Paquete;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaqueteController extends Controller
{

    public function MostrarTodosLosPaquetes(Request $Request)
    {
        try{
            $datoPaquete = Paquete::withTrashed()->get();
            $infoPaquete = [];
            if ($datoPaquete) {
                foreach ($datoPaquete as $dato) {
                    $infoPaquete[] = $this->obtenerPaquetes($dato);
                }
            }
            return $infoPaquete;
        } catch (\Exception $e){
            $mensajeDeError = 'Error: ';
            return $mensajeDeError;
        }
    }
    private function obtenerPaquetes($paquete)
    {
        try {
            $lugarEntrega = Lugares_Entrega::withTrashed()->where('id', $paquete['id_lugar_entrega'])->first();
            $caracteristica = Caracteristica::withTrashed()->where('id', $paquete['id_caracteristica_paquete'])->first();
            $estado = Estado_P::withTrashed()->where('id', $paquete['id_estado_p'])->first();
            $producto = Producto::withTrashed()->where('id', $paquete['id_producto'])->first();
            if ($producto && $lugarEntrega && $caracteristica) {
                return (
                    [
                        'Id Paquete' => $paquete['id'],
                        'Nombre del Paquete' => $paquete['nombre'],
                        'Fecha de Entrega' => $paquete['fecha_de_entrega'],
                        'Id Lugar Entrega' => $lugarEntrega['id'],
                        'Direccion' => $lugarEntrega['direccion'],
                        'Estado' => $estado['descripcion_estado_p'],
                        'Caracteristicas' => $caracteristica['descripcion_caracteristica'],
                        'Nombre del Remitente' => $paquete['nombre_remitente'],
                        'Nombre del Destinatario' => $paquete['nombre_destinatario'],
                        'Id del Producto' => $producto['id'],
                        'Producto' => $producto['nombre'],
                        'Volumen(L)' => $paquete['volumen_l'],
                        'Peso(Kg)' => $paquete['peso_kg'],
                        'created_at' => $paquete['created_at'],
                        'updated_at' => $paquete['updated_at'],
                        'deleted_at' => $paquete['deleted_at'],
                    ]);
            }
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

    public function ComprobarDatosPaquete(Request $request)
    {
        $validacion = $this->validacion($request->all());
        if ($validacion->fails())
            return ["errors" => $validacion->errors()];
        return $this->IngresarUnPaquete($request);
    }

    private function validacion($data)
    {
        return Validator::make(
            $data,
            [
                'nombre' => 'required|alpha|max:50|min:5',
                'volumen_l' => 'required|numeric|max:1000|min:1',
                'peso_kg' => 'required|numeric|max:1000|min:1',
                'id_estado_p' => 'required|numeric',
                'id_caracteristica_paquete' => 'required|numeric',
                'id_producto' => 'required|numeric|unique:productos',
                'id_lugar_entrega' => 'required|numeric',
                'nombre_destinatario' => 'required|alpha|max:100|min:3',
                'nombre_remitente' => 'required|alpha|max:100|min:3',
                'fecha_de_entrega' => 'required|date'

            ],
        );
    }

    public function IngresarUnPaquete(Request $request)
    {
        $Paquete = new Paquete;
        $Paquete->nombre = $request->post("nombre");
        $Paquete->volumen_l = $request->post("volumenEnL");
        $Paquete->peso_kg = $request->post("pesoEnKg");
        $Paquete->id_estado_p = $request->post("estado");
        $Paquete->id_caracteristica_paquete = $request->post("tipoDePaquete");
        $Paquete->id_producto = $request->post("idProducto");
        $Paquete->id_lugar_entrega = $request->post("idLugarEntrega");
        $Paquete->nombre_destinatario = $request->post("nombreDelDestinatario");
        $Paquete->nombre_remitente = $request->post("nombreDelRemitente");
        $Paquete->fecha_de_entrega = $request->post("fechaDeEntrega");

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
