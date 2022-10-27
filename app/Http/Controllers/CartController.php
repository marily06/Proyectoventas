<?php

namespace App\Http\Controllers;

use App\Events\NuevoPedidoEvento;
use App\Mail\PedidoWebMail;
use App\Models\Cliente;
use App\Models\Item;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\VentaEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartController extends AppBaseController
{


    public function index (Request $request) {


//        if ( ! session()->has('orden')) {
//            flash('Ingrese sus datos para la búsqueda del local mas cercano y generar una nueva orden')->warning()->important();
//            return redirect(route('locales'));
//        }

        //Si no esta la variable de session cart se crea
        if ( ! session()->has('carrito')) {
            session()->put('carrito', new Collection());
            session()->save();
        }

        $carro = session('carrito');

        $this->actualizaCantidades($request->cantidades);


        return view('ecommerce.carrito', compact('carro'));


    }

    public function data()
    {

//        if ( ! request()->ajax()) {
//            dd('Acceso denegado');
//        }

        $carro = session('carrito');

        if ($carro){
            $carro = $carro->count() > 0 ? $carro : collect();
        }else{
            $carro = collect();
        }




        return $this->sendResponse($carro,'Carro de compra');

    }

    public function agregar (Request $request) {
//        if ( ! request()->ajax()) {
//            abort(401, 'Acceso denegado');
//        }


        /**
         * @var Collection $carrito
         */
        $carrito = session('carrito');


        //si el carrito de compra no contiene el producto lo agrega
        if ( ! $carrito->contains('id', $request->item_id)) {

            $product = Item::find($request->item_id);

            $product->setAttribute('cantidad', $request->cantidad ?? 1);
            $carrito->push($product);
        }

        //si el carrito de compra Sí contiene el producto suma
        else {

            $carrito->map(function ($product) use ($request) {

                if ($product->id == $request->item_id) {
                    $product->cantidad += $request->cantidad ??  1;
                }
            });

            session()->put('carrito',$carrito);
        }

        session()->save();

        return $this->sendResponse($carrito,'Agregado con éxito,');
    }

    public function remove($productId) {
//        if ( ! request()->ajax()) {
//            abort(401, 'Acceso denegado');
//        }

        $carrito = session('carrito');

        $filtered = $carrito->filter(function ($product) use ($productId) {
            if($product->id != $productId){
                return $product;
            }
        });

        session()->put('carrito', $filtered);
        session()->save();

        return $this->sendResponse($carrito,'Removido con éxito');
    }

    public function actualizaCantidades($cantidades=null)
    {
        $carro = session('carrito');

        if ($cantidades){
            $carro = $carro->map(function ($product) use ($cantidades) {
                $product->cantidad = $cantidades[$product->id];
                return $product;
            });

            session()->put('carrito', $carro);
            session()->save();
        }

    }

    public function totalCarro()
    {
        return session('carrito')->sum(function ($item){
            return $item->cantidad * $item->precio_venta;
        });
    }

    public function pagar(Request $request){

        if ( ! session()->has('carrito')) {
            return redirect(route('home'));
        }

        $this->actualizaCantidades($request->cantidades);


        return view('ecommerce.pagar');

    }

    /**
     * @throws \Exception
     */
    public function confirmaPago(Request $request)
    {

        $data = $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
            'tipo_pago' => 'required',
            'direccion' => 'required',
        ]);

        try {
            DB::beginTransaction();


            /**
             * @var Venta $venta
             */
            $venta = $this->procesarOrden($request);

            $this->eventoYCorreo($venta);

        } catch (\Exception $exception) {
            DB::rollBack();

            manejarExcepcion($exception);

            return redirect()->back()->withInput();
        }


        DB::commit();


        return redirect(route('carrito.exito',$venta->id));

    }

    public function eventoYCorreo(Venta $venta)
    {

        try {
            if ($venta->correo){

                $msg ="Su pedido N° ".$venta->id." ha sido recibido con éxito";
                Mail::send(new PedidoWebMail($venta,$msg));

            }

            event(new NuevoPedidoEvento($venta));

        }catch (\Exception $exception){



        }
    }

    public function procesarOrden(Request $request)
    {



        /**
         * @var Collection $carro
         */
        $carro = session('carrito');

        $cliente = Cliente::updateOrCreate(
            [
                'telefono' => $request->telefono
            ],
            [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'email' => $request->correo,
                'direccion' => $request->direccion
            ]
        );


        //Crea encabezado de la orden
        $venta = Venta::create([
            'fecha' => hoyDb(),
            'estado_id' => VentaEstado::PAGADA,
            'cliente_id' => $cliente->id,
            'direccion' => $request->direccion,
            'tipo_pago_id' => $request->tipo_pago,
            'observaciones' => $request->notas,
            'nombre_entrega' => $cliente->full_name,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'credito' => $request->credito ?? 0,
            'web' => 1,
        ]);


        $detalles = $carro->map(function ($det){
            return new VentaDetalle([
                'item_id' => $det->id,
                'cantidad' => $det->cantidad,
                'precio' => $det->precio_venta,
            ]);
        });

        $venta->detalles()->saveMany($detalles);
        $venta->save();


        return $venta;

    }

    public function exito($id){


        $venta = Venta::with(['cliente','detalles.item'])->find($id);

        session()->forget('carrito');

//        flash('Su pedido N° '.$venta->id.' ha finalizado con éxito')->success()->important();

        return view('ecommerce.exito',compact('venta'));

    }

    public function imprimeFactura($id)
    {

        $venta = Venta::with(['cliente','detalles.item'])->find($id);

        return view('ecommerce.factura',compact('venta'));
    }


}
