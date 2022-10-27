<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable()->index('fk_venta_cliente1_idx');
            $table->date('fecha')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->time('hora_entrega')->nullable();
            $table->decimal('recibido', 12)->nullable()->default(0.00);
            $table->decimal('monto_delivery', 12)->nullable()->default(0.00);
            $table->boolean('delivery')->nullable()->default(0);
            $table->text('direccion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('nombre_entrega')->nullable();
            $table->char('telefono', 20)->nullable();
            $table->string('correo')->nullable();
            $table->boolean('web')->nullable()->default(0);
            $table->decimal('descuento', 12)->nullable()->default(0.00);
            $table->unsignedBigInteger('estado_id')->default(1)->index('fk_ventas_estado_venta1_idx');
            $table->unsignedBigInteger('tipo_pago_id')->nullable()->index('fk_venta_tipo_pago1_idx');
            $table->unsignedBigInteger('usuario_crea')->nullable()->index('fk_ventas_users1_idx');
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
        Schema::dropIfExists('ventas');
    }
}
