<?php

namespace App\Http\Controllers;

use App\DataTables\Scopes\ScopeVentaDataTable;
use App\DataTables\VentaDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Cliente;
use App\Models\Item;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\VentaEstado;
use App\Traits\VentaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Response;

class VentaController extends AppBaseController
{


    use VentaTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(VentaDataTable $ventaDataTable, Request $request)
    {


        $scope = new ScopeVentaDataTable();

        //si es la primera carga de la pagina es decir no se ha hecho ningun filtro
        if ( count($request->all()) == 0 ) {
            $scope->del =  iniMesDb();
            $scope->al =  hoyDb();
        }


        $ventaDataTable->addScope($scope);

        $subtitulo='';

        if ($request->cliente_id){
            $cliente = Cliente::find($request->cliente_id);
            $subtitulo .=  "<br> Cliente: ".$cliente->full_name;
        }

        if ($request->item_id){
            $item = Item::find($request->item_id);
            $marca_nombre = $item->marca->nombre ?? null;
            $subtitulo .=  "<br> Artículo: ".$item->nombre.' / '.$marca_nombre;
        }


        if ($request->estado){
            $sts = VentaEstado::find($request->estado);
            $subtitulo .=  "<br> Estado: ".$sts->nombre;
        }



        if ($scope->del && $scope->al){
            $subtitulo .=  "<br> Del: ".fecha($scope->del).' - Al: '.fecha($scope->al);
        }

        $ventaDataTable->setTitulo('Reporte de ventas');
        $ventaDataTable->setSubtitulo($subtitulo);


        return $ventaDataTable->render('ventas.index');
    }

    public function create()
    {
        $temporal = $this->obtenerTemporal();

        return view('ventas.create',compact('temporal'));

    }

    public function update(Venta $venta, UpdateVentaRequest $request)
    {


        $itemsStockInsuficiente= $this->validaStock($venta);



        if(count($itemsStockInsuficiente) > 0){


            return redirect()->back()->withErrors($itemsStockInsuficiente)->withInput();

        }else{


            try {
                DB::beginTransaction();

                $venta= $this->procesar($venta,$request);

            } catch (\Exception $exception) {
                DB::rollBack();

                manejarExcepcion($exception);

                return redirect()->back();
            }


            DB::commit();


            flash()->success('Venta procesada!.');


            return redirect(route('ventas.factura.view',$venta->id));

        }
    }

    public function show(Venta $venta)
    {
        return view('ventas.show')->with('venta', $venta);

    }

    public function procesar(Venta $venta,UpdateVentaRequest $request){


        $cliente = Cliente::find($request->cliente_id);

        $request->merge([
            'fecha' => hoyDb(),
            'estado_id' => VentaEstado::PAGADA,
            'cliente_id' => $cliente->id,
            'usuario_crea' => auth()->user()->id,
            'direccion' => $cliente->direccion,
            'nombre_entrega' => $cliente->full_name,
            'telefono' => $cliente->telefono,
            'correo' => $cliente->correo,
            'web' => 0,
        ]);

        /**
         * @var Venta $venta
         */
        $venta->fill($request->all());
        $venta->save();

        $venta->procesaEgresoStock();

        return $venta;
    }

    public function cancelar(Venta $venta){

        $venta->delete();

        flash()->success('Listo! venta cancelada.');

        return redirect(route('ventas.create'));
    }

    public function facturaView(Venta $venta)
    {
        return view('ventas.factura',compact('venta'));
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


    public function comprobanteHtml2Pdf(Venta $venta){



        $pdf = App::make('snappy.pdf.wrapper');

        $view = \View::make('ventas.comprobante_html2pdf', compact('venta'))->render();
        $footer = \View::make('ventas.footer_html2pdf')->render();

        $pdf->loadHTML($view)
            ->setPaper('letter')
            ->setOrientation('portrait')
            ->setOption('footer-html',utf8_decode($footer))
            ->setOption('margin-top',2)
            ->setOption('margin-bottom',10)
            ->setOption('margin-left',2)
            ->setOption('margin-right',2)
            ->stream('report.pdf');

        return $pdf->inline();



    }


    public function obtenerTemporal()
    {

        $user = auth()->user();

        $compra = Venta::temporal()->delUsuarioCrea()->first();


        if (!$compra){

            $compra =  Venta::create([
                'usuario_crea' => $user->id,
                'estado_id' => VentaEstado::TEMPORAL,
            ]);
        }

        return $compra;
    }


}
