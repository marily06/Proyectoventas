<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->text('especificaciones')->nullable();
            $table->string('codigo', 25)->nullable()->unique('codigo_UNIQUE');
            $table->decimal('precio_venta', 12);
            $table->decimal('precio_compra', 12)->default(0.00);
            $table->decimal('stock', 12)->default(0.00);
            $table->string('ubicacion')->nullable();
            $table->boolean('inventariable')->nullable()->default(1);
            $table->boolean('perecedero')->nullable()->default(0);
            $table->boolean('web')->nullable()->default(0);
            $table->boolean('portada')->nullable()->default(0);
            $table->unsignedBigInteger('marca_id')->nullable()->index('fk_items_marcas1_idx');
            $table->unsignedBigInteger('unimed_id')->nullable()->index('fk_items_unimeds1_idx');
            $table->unsignedBigInteger('categoria_id')->nullable()->index('fk_items_icategorias1_idx');
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
        Schema::dropIfExists('items');
    }
}
