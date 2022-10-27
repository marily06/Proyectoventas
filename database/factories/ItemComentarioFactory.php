<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemComentario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemComentarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemComentario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'item_id' => Item::all()->random()->id,
            'rating' => rand(1,5),
            'descripcion' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
