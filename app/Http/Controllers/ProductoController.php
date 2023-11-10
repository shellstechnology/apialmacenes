<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Moneda;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function MostrarTodosLosProductos(Request $Request)
    {
        $datoProducto = Producto::withTrashed()->get();
        $infoProducto = [];
        if ($datoProducto) {
            foreach ($datoProducto as $dato) {
                $infoProducto[] = $this->obtenerProducto($dato);
            }
        }
        $moneda = $this->obtenerMonedas();
        return [$infoProducto, $moneda];
    }

    public function MostrarUnproducto(Request $request, $idProducto)
    {
        $datoProducto = Producto::findOrFail($idProducto);
        $infoProducto = [];
        if ($datoProducto) {
            $infoProducto[] = $this->obtenerProducto($datoProducto);
        }
        return [$infoProducto];
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
        } catch (\Exception $e) {
            $mensajeDeError = 'Error: ';
            return $mensajeDeError;
        }

    }

    public function ComprobarDatosProducto(Request $request)
    {
        $validacion = $this->validacion($request->all());
        if ($validacion->fails())
            return ["errors" => $validacion->errors()];
        return $this->IngresarUnProducto($request);
    }

    private function validacion($data)
    {
        return Validator::make(
            $data,
            [
                'nombre' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:50|min:3',
                'precio' => 'required|numeric|max:1000|min:1',
                'stock' => 'required|numeric|max:1000|min:1',
                'idMoneda' => 'required|string'
            ],
        );
    }

    public function IngresarUnProducto($request)
    {
        $moneda=$this->devolverMoneda($request->post('idMoneda'));
        $Producto = new Producto;
        $Producto->nombre = $request->post("nombre");
        $Producto->precio = $request->post("precio");
        $Producto->stock = $request->post("stock");
        $Producto->id_moneda = $moneda;

        $Producto->save();

        return $Producto;
    }

    public function Eliminar(Request $request, $idProducto)
    {
        $Producto = Producto::findOrFail($idProducto);
        $Producto->delete();

        return ["mensaje" => "Producto $idProducto eliminado."];
    }

    public function Modificar(Request $request, $idProducto)
    {
        $moneda=$this->devolverMoneda($request->post('idMoneda'));
        $Producto = Producto::where('id', $idProducto)->update([
            'nombre' => $request->post('nombre'),
            'precio' => $request->post('precio'),
            'stock' => $request->post('stock'),
            'id_moneda' => $moneda
        ]);
        $productoVerdadero = Producto::findOrFail($idProducto);
        return $productoVerdadero;
    }

    public function restore($id)
    {
        Producto::withTrashed()->find($id)->restore();
        return back();
    }

    public function obtenerMonedas()
    {
        return Moneda::all(['moneda']);
    }

    public function devolverMoneda($moneda)
    {
        $idMoneda = Moneda::where('moneda', $moneda)->first();
        return $idMoneda['id'];
    }

}
