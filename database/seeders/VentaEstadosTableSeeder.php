<?php

namespace Database\Seeders;

use App\Models\VentaEstado;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaEstadosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('venta_estados')->truncate();

        VentaEstado::factory()->count(1)->create(['nombre' => 'TEMPORAL' ]);
        VentaEstado::factory()->count(1)->create(['nombre' => 'PAGADA' ]);
        VentaEstado::factory()->count(1)->create(['nombre' => 'PREPARANDO' ]);
        VentaEstado::factory()->count(1)->create(['nombre' => 'LISTA' ]);
        VentaEstado::factory()->count(1)->create(['nombre' => 'ENTREGADA' ]);
        VentaEstado::factory()->count(1)->create(['nombre' => 'ANULADA' ]);

    }
}
