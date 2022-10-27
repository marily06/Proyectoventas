<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVentaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->foreign('venta_id', 'fk_venta_detalle_venta1')->references('id')->on('ventas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('item_id', 'fk_venta_detalles_items1')->references('id')->on('items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->dropForeign('fk_venta_detalle_venta1');
            $table->dropForeign('fk_venta_detalles_items1');
        });
    }
}
