<?php

namespace Database\Factories;

use App\Models\TipoPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoPagoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoPago::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->text,
            'web' => $this->faker->word,
            'local' => $this->faker->word,
            'ruta_procesa' => $this->faker->word,
            'credenciales' => null,
            'icono' => null,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
