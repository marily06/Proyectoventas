<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('fk_item_comentarios_users1_idx');
            $table->unsignedBigInteger('item_id')->index('fk_item_comentarios_sitios1_idx');
            $table->integer('rating');
            $table->text('descripcion');
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
        Schema::dropIfExists('item_comentarios');
    }
}
