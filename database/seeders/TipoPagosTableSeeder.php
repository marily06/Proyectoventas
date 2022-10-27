<?php
namespace Database\Seeders;

use App\Models\TipoPago;
use Illuminate\Database\Seeder;

class TipoPagosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        TipoPago::factory()->count(1)->create([
            'nombre' => 'EFECTIVO',
            'descripcion' => 'Al recibir tu pedido',
            'web' => 1,
            'local' => 1,
            'ruta_procesa' => 'carro.procesar.efectivo',
        ]);

        TipoPago::factory()->count(1)->create([
            'nombre' => 'TARJETA DE CRÉDITO O DÉBITO',
            'descripcion' => 'Debes ingresar los datos de la tarjeta para procesar',
            'web' => 1,
            'local' => 1,
            'ruta_procesa' => 'carro.procesar.tcredito',
        ]);




    }
}
