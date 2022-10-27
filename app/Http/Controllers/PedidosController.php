<?php

namespace App\Http\Controllers;

use App\extensiones\PDF_AutoPrint;
use App\Mail\PedidoWebMail;
use App\Models\Item;
use App\Models\Role;
use App\Models\Venta;
use App\Models\VentaEstado;
use App\Models\User;
use App\Traits\VentaTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PedidosController extends AppBaseController
{

    use VentaTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $pedidos = Venta::tipoPedido()->with(['detalles.item','cliente','estado'])->orderBy('estado_id')->orderBy('id','desc')->get();

//        dd($pedidos);

        return view('pedidos.index',compact('pedidos'));
    }



    public function cambioEstado(Venta $venta)
    {

        try {
            DB::beginTransaction();

            $nuevoEstado = $this->nuevoEstado($venta->estado_id);


            $venta->estado_id = $nuevoEstado->id;
            $venta->save();

            if($nuevoEstado->id == VentaEstado::PREPARANDO){



                //si la orden o pedido fue realizado en e-commerce o tiene un fecha de entrega
                if($venta->web || !is_null($venta->fecha_entrega)){

                    $insuficientes=$this->validaStock($venta);

                    //si hay articulos con stock insuficiente

                    if(count($insuficientes) > 0){

                        return redirect(route('pedidos.index'))->withErrors($insuficientes);
                    }else{

                        $venta->procesaEgresoStock();

                    }
                }

                if($venta->fecha_entrega && $venta->fecha_entrega!=hoyDb()){
                    return $this->sendError('Aun no es el día de la entrega');
                }
            }



        } catch (Exception $exception) {
            DB::rollBack();

            manejarExcepcion($exception);
        }

        DB::commit();


//        flash($venta->estado->descripcion)->success();


        return redirect(route('pedidos.index'));

    }


    public function nuevoEstado($actualState=null)
    {
        switch ($actualState){
            case VentaEstado::PAGADA :
                $nuevoEstado= VentaEstado::PREPARANDO;
                break;
            case VentaEstado::PREPARANDO :
                $nuevoEstado= VentaEstado::LISTA;
                break;
            case VentaEstado::LISTA :
                $nuevoEstado= VentaEstado::ENTREGADA;
                break;
            default:
                $nuevoEstado = false;
        }

        return VentaEstado::find($nuevoEstado);
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

        return redirect(route('pedidos.index'));

    }



}
