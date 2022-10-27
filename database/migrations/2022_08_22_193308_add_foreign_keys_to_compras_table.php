<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('usuario_crea', 'fk_compras_users1')->references('id')->on('users');
            $table->foreign('proveedor_id', 'fk_compra_proveedores1')->references('id')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('tipo_id', 'fk_compras_compras_tipos1')->references('id')->on('compra_tipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuario_recibe', 'fk_compras_users2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('estado_id', 'fk_compras_compra_estados1')->references('id')->on('compra_estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign('fk_compras_users1');
            $table->dropForeign('fk_compra_proveedores1');
            $table->dropForeign('fk_compras_compras_tipos1');
            $table->dropForeign('fk_compras_users2');
            $table->dropForeign('fk_compras_compra_estados1');
        });
    }
}
