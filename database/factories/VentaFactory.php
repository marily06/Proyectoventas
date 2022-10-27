<?php

namespace Database\Factories;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente_id' => $this->faker->word,
        'fecha' => $this->faker->word,
        'fecha_entrega' => $this->faker->word,
        'hora_entrega' => $this->faker->word,
        'recibido' => $this->faker->word,
        'monto_delivery' => $this->faker->word,
        'delivery' => $this->faker->word,
        'direccion' => $this->faker->text,
        'observaciones' => $this->faker->text,
        'nombre_entrega' => $this->faker->word,
        'telefono' => $this->faker->word,
        'correo' => $this->faker->word,
        'web' => $this->faker->word,
        'descuento' => $this->faker->word,
        'estado_id' => $this->faker->word,
        'tipo_pago_id' => $this->faker->word,
        'usuario_crea' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
