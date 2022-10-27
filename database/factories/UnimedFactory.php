<?php

namespace Database\Factories;

use App\Models\Unimed;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnimedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unimed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'simbolo' => $this->faker->word,
            'nombre' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
