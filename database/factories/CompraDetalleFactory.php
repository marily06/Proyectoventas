<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraEstado;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraDetalleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompraDetalle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $fechaVence = Carbon::now()->addMonths(rand(3,16));

        /**
         * @var Item $item
         */
        $item = Item::all()->random();

        return [
            'compra_id' => Compra::all()->random()->id,
            'item_id' => $item->id,
            'cantidad' => $this->faker->randomFloat(2,10,50),
            'precio' => $item->precio_compra,
            'descuento' => 0,
            'fecha_vence' => Carbon::now()->addYear()->format('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),

        ];
    }
}
