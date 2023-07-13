<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaqueteController extends Controller
{

        public function MostrarTodosLosPaquetes(Request $Request){
            $Paquetes = Paquete::all();
            return view("almacen", ["Paquetes" => $Paquetes]);
        }
     

        public function ListarUnPaquete(Request $request, $idPaquete){
            return Persona::findOrFail($idPaquete);
    
        }
      
        public function IngresarUnPaquete(Request $request){
            $Paquete = new Paquete;
            if($request -> post("nombre")== null || 
            $request -> post("estado")== null  ||
            $request -> post("volumenEnL")== null ||
            $request -> post("pesoEnKg")== null ||
            $request -> post("tipoDePaquete")== null ||
            $request -> post("nombreDelDestinatario")== null ||
            $request -> post("nombreDelRemitente")== null ||
            $request -> post("fechaDeEntrega")== null 
              )
                return abort(403);
            $Paquete -> nombre = $request -> post("nombre");
            $Paquete -> estado = $request -> post("estado");
            $Paquete -> volumen_l = $request -> post("volumenEnL");
            $Paquete -> peso_kg = $request -> post("pesoEnKg");
            $Paquete -> tipo_Paquete = $request -> post("tipoDePaquete");
            $Paquete -> nombre_del_destinatario = $request -> post("nombreDelDestinatario");
            $Paquete -> nombre_del_remitente = $request -> post("nombreDelRemitente");
            $Paquete -> fecha_de_entrega = $request -> post("fechaDeEntrega");
    
            $Paquete -> save();
    
            return $Paquete;
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function show(Paquete $paquete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function edit(Paquete $paquete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paquete $paquete)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paquete $paquete)
    {
        //
    }
}
