<?php

namespace Database\Factories;

use App\Models\VentaDetalle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaDetalleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VentaDetalle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'venta_id' => $this->faker->word,
        'item_id' => $this->faker->word,
        'cantidad' => $this->faker->word,
        'precio' => $this->faker->word,
        'precio_compra' => $this->faker->word,
        'descuento' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
