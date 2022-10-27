<?php
namespace Database\Seeders;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('clientes')->truncate();

        \DB::table('clientes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nit' => 'CF',
                'nombres' => 'Consumidor',
                'apellidos' => 'Final',
                'telefono' => NULL,
                'email' => NULL,
                'genero' => 'M',
                'fecha_nacimiento' => NULL,
                'direccion' => NULL,
                'created_at' => '2017-04-17 11:05:46',
                'updated_at' => '2017-06-01 10:18:42',
                'deleted_at' => NULL,
            )
        ));


        if (app()->environment()=='local'){
//            Cliente::factory()->count(20)->create();
        }


    }
}
