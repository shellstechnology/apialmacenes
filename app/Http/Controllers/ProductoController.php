<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function MostrarTodosLosProductos(Request $Request)
    {
        return Producto::all();
    }

    public function MostrarUnproducto(Request $request, $idProducto)
    {
        return Producto::findOrFail($idProducto);
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
                'nombre' => 'required|regex:/^[\pL\s\-]+$/u|max:50|min:3',
                'precio' => 'required|numeric|max:1000|min:1',
                'stock' => 'required|numeric|max:1000|min:1',
                'idMoneda' => 'required|numeric'
            ],
        );
    }

    public function IngresarUnProducto(Request $request)
    {
        $Producto = new Producto;
        $Producto->nombre = $request->post("nombre");
        $Producto->precio = $request->post("precio");
        $Producto->stock = $request->post("stock");
        $Producto->id_moneda = $request->post("idMoneda");

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
        $Producto = Producto::findOrFail($idProducto);
        $Producto->nombre = $request->post("nombre");
        $Producto->precio = $request->post("precio");
        $Producto->stock = $request->post("stock");
        $Producto->id_moneda = $request->post("idMoneda");

        $Producto->save();

        return $Producto;
    }

    public function restore($id)
    {
        Producto::withTrashed()->find($id)->restore();

        return back();
    }

}
