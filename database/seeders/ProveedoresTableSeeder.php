<?php
namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProveedoresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('proveedores')->truncate();


        if(App::environment()=='local'){
            Proveedor::factory()->count(1)->create([
                'nit' => '00000',
                'nombre' => 'Proveedor de prueba 2',
                'razon_social' => 'Proveedor de prueba 2 S.A',
                'correo' => '',
            ]);

            Proveedor::factory()->count(1)->create([
                'nit' => '00000',
                'nombre' => 'Proveedor de prueba 3',
                'razon_social' => 'Proveedor de prueba 3 S.A',
                'correo' => '',
            ]);
        }


    }
}
