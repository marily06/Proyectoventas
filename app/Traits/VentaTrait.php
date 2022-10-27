<?php


namespace App\Traits;


use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;

trait VentaTrait
{

    /**
     * Devuelve un array con los items los cuales no alcanza el stock según la suma de las cantidades de los detalles
     * (No valida los artículos que son combos)
     * @param Venta $venta
     * @return array
     */
    public function validaStock(Venta $venta){

        $insuficiente=array();

        /**
         * @var VentaDetalle $detalle
         */
        foreach ($venta->detalles as $detalle){
            $item = $detalle->item;

            //si el item es inventariable y el stock de la tienda es menor a la cantidad
            if($item->inventariable && $item->stock < $detalle->cantidad){
                $insuficiente[]="El articulo ".$detalle->item->nombre.", tiene ".nf($detalle->item->stock,0)." existencias e intenta vender ".nf($detalle->cantidad);
            }
        }


        return $insuficiente;
    }

    public function anular(Venta $venta){

        try {
            DB::beginTransaction();

            $venta->anular();

        } catch (\Exception $exception) {
            DB::rollBack();

            errorException($exception);

            return redirect()->back();
        }


        DB::commit();

        flash()->success('Listo! venta anulada.');

        if (back()->getTargetUrl()==route('ventas.por_cobrar')){
            return redirect(route('ventas.por_cobrar'));
        }

        return redirect(route('ventas.index'));
    }
}
