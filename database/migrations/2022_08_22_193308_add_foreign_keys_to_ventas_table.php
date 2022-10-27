<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->foreign('usuario_crea', 'fk_ventas_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('cliente_id', 'fk_venta_cliente1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('tipo_pago_id', 'fk_ventas_tipo_pago1')->references('id')->on('tipo_pagos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('estado_id', 'fk_ventas_estado_venta1')->references('id')->on('venta_estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign('fk_ventas_users1');
            $table->dropForeign('fk_venta_cliente1');
            $table->dropForeign('fk_ventas_tipo_pago1');
            $table->dropForeign('fk_ventas_estado_venta1');
        });
    }
}
