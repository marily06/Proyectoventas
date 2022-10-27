<?php

namespace Database\Factories;

use App\Models\Marca;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

class MarcaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Marca::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->randomElement(['lenovo','dell','nike','sara','samsung','motorola']),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Marca $marca){


            $this->faker->addProvider(new PicsumProvider($this->faker));
            $this->faker->addProvider(new LoremSpaceProvider($this->faker));


            try {

                $categoria = $this->faker->randomElement([
                    LoremSpaceProvider::CATEGORY_FASHION
                ]);

                $url = $this->faker->loremSpace($categoria,storage_path('temp'));

                $marca->addMedia($url)->toMediaCollection('marcas');


            }catch (\Exception $exception){
                throw $exception;
            }

        });


    }


}
