<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraEstado;
use App\Models\CompraTipo;
use App\Models\Proveedor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Compra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // fechas entre hoy y hace x dias
        $dias = 30;
        $fechaCrea = Carbon::now()->subDays(rand(0,$dias));
        $estado = CompraEstado::whereNotIn('id',[CompraEstado::TEMPORAL,CompraEstado::CANCELADA])->get()->random()->id;


        $fechaDocumento = $fechaCrea->copy()->addDays(rand(0,3));

        $fechaIngreso = null;
        if($estado == CompraEstado::RECIBIDA ){
            $fechaIngreso = $fechaDocumento->copy()->addDays(rand(0,3));

        }


        return [
            'tipo_id' => CompraTipo::all()->random()->id,
            'proveedor_id' => Proveedor::all()->random()->id,
            'fecha_documento' => $fechaDocumento,
            'fecha_ingreso' => $fechaIngreso,
            'serie' => $this->faker->randomElement(['A','B','C']),
            'numero' => $this->faker->randomNumber(6),
            'usuario_crea' => User::all()->random()->id,
            'usuario_recibe' => User::all()->random()->id,
            'estado_id' => $estado,
            'created_at' => $fechaCrea,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Compra $compra){

            $compra->codigo = $this->getCodigo();
            $compra->correlativo = $this->getCorrelativo();
            $compra->save();
        });
    }

    public function getCodigo($cantidadCeros = 3)
    {
        return "CPA-".prefijoCeros($this->getCorrelativo(),$cantidadCeros)."-".Carbon::now()->year;
    }

    public function getCorrelativo()
    {

        $correlativo = Compra::withTrashed()->whereRaw('year(created_at) ='.Carbon::now()->year)->max('correlativo');


        if ($correlativo)
            return $correlativo+1;

        return 1;
    }


}
