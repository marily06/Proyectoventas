<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnimedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('unimeds')->truncate();

        DB::table('unimeds')->insert(array (
            0 =>
            array (
                'id' => 1,
                'simbolo' => 'U',
                'nombre' => 'Unidad',
                'created_at' => '2017-07-28 10:06:37',
                'updated_at' => '2017-07-28 10:06:37',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'simbolo' => 'Kl',
                'nombre' => 'Kilos',
                'created_at' => '2017-07-28 10:07:02',
                'updated_at' => '2018-08-12 11:23:56',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'simbolo' => 'Gm',
                'nombre' => 'Gramos',
                'created_at' => '2017-07-28 10:07:30',
                'updated_at' => '2017-07-28 10:07:30',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 12,
                'simbolo' => 'Ltr',
                'nombre' => 'Litros',
                'created_at' => '2018-08-12 11:25:15',
                'updated_at' => '2018-08-12 11:25:15',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 13,
                'simbolo' => 'CC',
                'nombre' => 'Centímetros Cúbicos',
                'created_at' => '2018-08-12 11:25:58',
                'updated_at' => '2018-08-12 11:25:58',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 14,
                'simbolo' => 'ml',
                'nombre' => 'Mililitros',
                'created_at' => '2018-08-12 11:26:14',
                'updated_at' => '2018-08-12 11:26:14',
                'deleted_at' => NULL,
            ),
        ));


    }
}
