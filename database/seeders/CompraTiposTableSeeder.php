<?php

namespace Database\Seeders;

use App\Models\CompraTipo;
use Illuminate\Database\Seeder;

class CompraTiposTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('compra_tipos')->truncate();


        CompraTipo::factory()->count(1)->create(['nombre' => 'FACTURA']);

    }
}
