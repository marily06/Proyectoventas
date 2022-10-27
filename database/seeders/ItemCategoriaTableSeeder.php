<?php
namespace Database\Seeders;

use App\Models\ItemCategoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategoriaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (app()->environment()=='local'){

            DB::table('item_categorias')->truncate();

            ItemCategoria::factory()->count(5)->create();
        }


    }
}
