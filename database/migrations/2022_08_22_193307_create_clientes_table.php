<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->char('nit', 10)->nullable()->unique('clt_nit_UNIQUE');
            $table->char('dpi', 13)->nullable()->unique('clt_dpi_UNIQUE');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->char('telefono', 20)->nullable();
            $table->char('telefono2', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->enum('genero', ['M', 'F']);
            $table->date('fecha_nacimiento')->nullable();
            $table->text('direccion')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
