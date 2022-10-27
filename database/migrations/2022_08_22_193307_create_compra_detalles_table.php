<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compra_id')->index('fk_compra_detalles_compra1_idx');
            $table->unsignedBigInteger('item_id')->index('fk_compra_detalles_items1_idx');
            $table->decimal('cantidad', 12);
            $table->decimal('precio', 12);
            $table->decimal('descuento', 12)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra_detalles');
    }
}
