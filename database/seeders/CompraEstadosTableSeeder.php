<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompraEstadosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('compra_estados')->truncate();

        \DB::table('compra_estados')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nombre' => 'TEMPORAL',
                'created_at' => '2017-05-18 10:50:31',
                'updated_at' => '2018-08-17 10:06:32',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'nombre' => 'CREADA',
                'created_at' => '2017-05-18 10:50:31',
                'updated_at' => '2018-08-17 10:06:44',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'nombre' => 'RECIBIDA',
                'created_at' => '2018-08-17 10:01:05',
                'updated_at' => '2018-08-17 10:03:27',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'nombre' => 'CANCELADA',
                'created_at' => '2018-08-17 10:03:49',
                'updated_at' => '2018-08-17 10:03:49',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'nombre' => 'ANULADA',
                'created_at' => '2018-08-17 10:03:49',
                'updated_at' => '2018-08-17 10:03:49',
                'deleted_at' => NULL,
            ),
        ));



    }
}
