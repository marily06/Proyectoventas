<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemHasCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_has_categoria', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->index('fk_icategorias_has_items_items1_idx');
            $table->unsignedBigInteger('categoria_id')->index('fk_icategorias_has_items_icategorias1_idx');
            $table->primary(['item_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_has_categoria');
    }
}
