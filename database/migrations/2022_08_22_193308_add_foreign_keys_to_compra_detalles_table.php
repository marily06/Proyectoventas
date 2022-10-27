<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compra_detalles', function (Blueprint $table) {
            $table->foreign('compra_id', 'fk_compra_detalles_compra1')->references('id')->on('compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('item_id', 'fk_compra_detalles_items1')->references('id')->on('items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compra_detalles', function (Blueprint $table) {
            $table->dropForeign('fk_compra_detalles_compra1');
            $table->dropForeign('fk_compra_detalles_items1');
        });
    }
}
