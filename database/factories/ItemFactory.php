<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemCategoria;
use App\Models\Marca;
use App\Models\Unimed;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $precio_compra = $this->faker->randomFloat(2,10,50);
        $precio_venta = $precio_compra * 1.3;

        $nombres = include(app_path("Faker/items.php"));


        return [
            'nombre' => $this->faker->randomElement($nombres),
            'descripcion' => $this->faker->paragraph,
            'especificaciones' => $this->faker->text,
            'codigo' => $this->faker->unique()->randomNumber(5),
            'precio_venta' => $precio_venta,
            'precio_compra' => $precio_compra,
            'stock' => rand(20,40),
            'ubicacion' => $this->faker->word,
            'inventariable' => 1,
            'perecedero' => rand(0,1),
            'web' => 1,
            'portada' => rand(0,1),
            'marca_id' => Marca::all()->random()->id,
            'unimed_id' => Unimed::all()->random()->id,
            'categoria_id' => ItemCategoria::all()->random()->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }

    public function configure()
    {

        return $this->afterCreating(function (Item $item){

            $item->categorias()->attach(ItemCategoria::pluck('id')->random(4));

            $this->imagen($item);


        });
    }

    public function imagen(Item $item)
    {
        $this->faker->addProvider(new PicsumProvider($this->faker));
        $this->faker->addProvider(new LoremSpaceProvider($this->faker));

        try {

            $categoria = $this->faker->randomElement([
                LoremSpaceProvider::CATEGORY_FASHION,
                LoremSpaceProvider::CATEGORY_SHOES,
                LoremSpaceProvider::CATEGORY_WATCH,
            ]);

            $url1 = $this->faker->loremSpace($categoria,storage_path('temp'));
            $url2= $this->faker->loremSpace($categoria,storage_path('temp'));

            $item->addMedia($url1)
                ->toMediaCollection('items');


            $item->addMedia($url2)
                ->toMediaCollection('items');

        }catch (\Exception $exception){
            throw $exception;
        }

    }


}
