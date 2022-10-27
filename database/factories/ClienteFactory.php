<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nit' => $this->faker->word,
        'dpi' => $this->faker->word,
        'nombres' => $this->faker->word,
        'apellidos' => $this->faker->word,
        'telefono' => $this->faker->word,
        'telefono2' => $this->faker->word,
        'email' => $this->faker->word,
        'genero' => $this->faker->word,
        'fecha_nacimiento' => $this->faker->word,
        'direccion' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
