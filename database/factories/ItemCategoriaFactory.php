<?php

namespace Database\Factories;

use App\Models\ItemCategoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

class ItemCategoriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemCategoria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->randomElement(['oficina','kits','iluminación','herramienta','cosmeticos']),
            'descripcion' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ItemCategoria $itemCategoria){


            $this->faker->addProvider(new PicsumProvider($this->faker));
            $this->faker->addProvider(new LoremSpaceProvider($this->faker));


            try {

                $categoria = $this->faker->randomElement([
                    LoremSpaceProvider::CATEGORY_FASHION
                ]);

                $url = $this->faker->loremSpace($categoria,storage_path('temp'));

                $itemCategoria->addMedia($url)->toMediaCollection('categorias');


            }catch (\Exception $exception){
                throw $exception;
            }

        });
    }


}
