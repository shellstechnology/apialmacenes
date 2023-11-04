<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use App\Models\Estado_P;
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
            $datoPaquete = Paquete::withTrashed()->get();
            $infoPaquete = [];
            $datoLugarEntrega = Lugares_Entrega::withoutTrashed()->get();
            $idLugaresEntrega = [];
            $datoProducto = Producto::withoutTrashed()->get();
            $idProductos = [];
            $datoCaracteristica = Caracteristica::withoutTrashed()->get();
            $descripcionCaracteristica = [];
            $datoEstadoPaquete = Estado_p::withoutTrashed()->get();
            $estadoPaquete = [];
            foreach ($datoPaquete as $dato) {
                $infoPaquete[] = $this->obtenerPaquetes($dato);
            }
   
            foreach ($datoCaracteristica as $dato) {
                $descripcionCaracteristica[] = $dato['descripcion_caracteristica'];
            }
            foreach ($datoEstadoPaquete as $dato) {
                $estadoPaquete[] = $dato['descripcion_estado_p'];
            }
            $idLugaresEntrega = $this->obtenerIdsClase($datoLugarEntrega);
            $idProductos = $this->obtenerIdsClase($datoProducto);
            return [$infoPaquete,$descripcionCaracteristica,$idProductos,$infoPaquete,$estadoPaquete];
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
                        'Direccion' => $lugarEntrega['direccion'],
                        'Latitud'=> $lugarEntrega['latitud'],
                        'Longitud'=> $lugarEntrega['longitud'],
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

    private function obtenerIdsClase($datoClase)
    {
        try {
            $datoId = [];
            foreach ($datoClase as $dato) {
                $datoId[] = $dato['id'];
            }
            return $datoId;
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: no se pudieron cargar los datos';
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


    private function validacion($data)
    {
        return Validator::make(
            $data,
            [
                'nombre' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:50|min:5',
                'volumen_l' => 'required|numeric|max:1000|min:1',
                'peso_kg' => 'required|numeric|max:1000|min:1',
                'id_estado_p' => 'required|string',
                'id_caracteristica_paquete' => 'required|string',
                'id_producto' => 'required|numeric',
                'nombre_destinatario' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:100|min:3',
                'nombre_remitente' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:100|min:3',
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
        $estado=$this->obtenerIdEstado($request->post('id_estado_p'));
        $caracteristica=$this->obtenerIdCaracteristica($request->post('id_caracteristica_paquete'));
        $Paquete = new Paquete;
        $Paquete->nombre = $request->post("nombre");
        $Paquete->volumen_l = $request->post("volumen_l");
        $Paquete->peso_kg = $request->post("peso_kg");
        $Paquete->id_estado_p = $estado;
        $Paquete->id_caracteristica_paquete = $caracteristica;
        $Paquete->id_producto = $request->post("id_producto");
        $Paquete->id_lugar_entrega = $idDireccion;
        $Paquete->nombre_destinatario = $request->post("nombre_destinatario");
        $Paquete->nombre_remitente = $request->post("nombre_remitente");

        $Paquete->save();

        return $Paquete;
    }
   
    public function ComprobarDatosPaqueteAModificar(Request $request, $idPaquete)
    {
        $validacion = $this->validacion($request->all());
        if ($validacion->fails())
            return ["errors" => $validacion->errors()];
        return $this->ModificarUnPaqueteConDireccion($request, $idPaquete);
    }

    public function ModificarUnPaqueteConDireccion(Request $request, $idPaquete){
        $this -> lockTables();
        DB::beginTransaction();
        $this -> IngresarDireccion($request);
        $ultimaDireccion = Lugares_Entrega::latest('created_at')->first();
        $idUltimaDireccion = $ultimaDireccion['id'];
        $this -> Modificar($request,  $idUltimaDireccion, $idPaquete);
        DB::commit();
        DB::raw('UNLOCK TABLES');
        $paquete = Paquete::findOrFail($idPaquete);
        return $paquete;
    }


    public function Modificar(Request $request,$idDireccion, $idPaquete)
    {
        $estado=$this->obtenerIdEstado($request->post('id_estado_p'));
        $caracteristica=$this->obtenerIdCaracteristica($request->post('id_caracteristica_paquete'));
        $Paquete = Paquete::findOrFail($idPaquete);
        $Paquete->update([
            'nombre'=>$request->post("nombre"),
            'volumen_l' => $request->post("volumen_l"),
            'peso_kg' => $request->post("peso_kg"),
            'id_estado_p' => $estado,
            'id_caracteristica_paquete' => $caracteristica,
            'id_producto' => $request->post("id_producto"),
            'id_lugar_entrega' => $idDireccion,
            'nombre_destinatario' => $request->post("nombre_destinatario"),
            'nombre_remitente' => $request->post("nombre_remitente"),
        ]);
        return $Paquete;
    }

    private function obtenerIdCaracteristica($caracteristica)
    {
        try {
            $caracteristica = Caracteristica::withoutTrashed()->where('descripcion_caracteristica', $caracteristica)->first();
            return $caracteristica['id'];
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
        }
    }

    private function obtenerIdEstado($estado)
    {
        try {
            $estado = Estado_p::withTrashed()->where('descripcion_estado_p', $estado)->first();
            return $estado['id'];
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
        }
    }

    public function Eliminar(Request $request, $idPaquete)
    {
        $Paquete = Paquete::findOrFail($idPaquete);
        $Paquete->delete();

        return ["mensaje" => "Paquete $idPaquete eliminado."];
    }

    public function restore($id)
    {
        Paquete::withTrashed()->find($id)->restore();

        return back();
    }
}
