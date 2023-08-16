<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('volumen_l');
            $table->float('peso_kg');
            $table->integer('id_estado_p');
            $table->integer('id_caracteristica_paquete');
            $table->integer('id_producto');
            $table->integer('tipo_paquete');
            $table->integer('id_lugar_entrega');
            $table->string('nombre_del_destinatario');
            $table->string('nombre_del_remitente');
            $table->datetime('fecha_de_entrega');
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paquetes');
    }
};
