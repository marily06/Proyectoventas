<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proveedor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nit' => $this->faker->randomNumber(  8),
            'nombre' => $this->faker->name,
            'razon_social' => $this->faker->company,
            'correo' => $this->faker->email,
            'telefono_movil' => $this->faker->randomNumber(8),
            'telefono_oficina' => $this->faker->randomNumber(8),
            'direccion' => $this->faker->address,
            'observaciones' => $this->faker->text,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
