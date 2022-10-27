<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItemHasCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_has_categoria', function (Blueprint $table) {
            $table->foreign('categoria_id', 'fk_icategorias_has_items_icategorias1')->references('id')->on('item_categorias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('item_id', 'fk_icategorias_has_items_items1')->references('id')->on('items')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_has_categoria', function (Blueprint $table) {
            $table->dropForeign('fk_icategorias_has_items_icategorias1');
            $table->dropForeign('fk_icategorias_has_items_items1');
        });
    }
}
