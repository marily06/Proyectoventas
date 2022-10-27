<?php
namespace Database\Seeders;

use App\Models\ItemCategoria;
use App\Models\Item;
use App\Models\ItemComentario;
use App\Models\Kardex;
use App\Models\Marca;
use App\Models\Renglon;
use App\Models\Stock;
use App\Models\Unimed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {



        if (app()->environment()=='local'){


            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            DB::table('items')->truncate();
            DB::table('item_has_categoria')->truncate();
            DB::table('compras')->truncate();
            DB::table('compra_detalles')->truncate();

            Item::factory()->count(10)->create()->each(function (Item $item){
                ItemComentario::factory()->count(rand(4,6))
                    ->create(['item_id' => $item->id]);
            });

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }



    }
}
