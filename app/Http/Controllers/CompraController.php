<?php

namespace App\Http\Controllers;

use App\DataTables\CompraDataTable;
use App\DataTables\Scopes\ScopeCompraDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraEstado;
use App\Models\Item;
use App\Models\Proveedor;
use Carbon\Carbon;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class CompraController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Compras')->only(['show']);
        $this->middleware('permission:Crear Compras')->only(['create','store']);
        $this->middleware('permission:Editar Compras')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Compras')->only(['destroy']);
    }

    /**
     * Display a listing of the Compra.
     *
     * @param CompraDataTable $compraDataTable
     * @return Response
     */
    public function index(CompraDataTable $compraDataTable,Request $request)
    {

        $scope = new ScopeCompraDataTable();

        //si es la primera carga de la pagina es decir no se ha hecho ningun filtro
        if ( count($request->all()) == 0 ) {
            $scope->del =  iniMesDb();
            $scope->al =  hoyDb();
        }

        $compraDataTable->addScope($scope);

        $subtitulo='';

        if ($request->proveedor_id){
            $proveedor = Proveedor::find($request->proveedor_id);
            $subtitulo .=  "<br> Cliente: ".$proveedor->nombre;
        }

        if ($request->item_id){
            $item = Item::find($request->item_id);
            $marca_nombre = $item->marca->nombre ?? null;
            $subtitulo .=  "<br> Artículo: ".$item->nombre.' / '.$marca_nombre;
        }


        if ($request->estado_id){
            $sts = CompraEstado::find($request->estado_id);
            $subtitulo .=  "<br> Estado: ".$sts->nombre;
        }

        if ($scope->del && $scope->al){
            $subtitulo .=  "<br> Del: ".fecha($scope->del).' - Al: '.fecha($scope->al);
        }

        $compraDataTable->setTitulo('Reporte de Compras');
        $compraDataTable->setSubtitulo($subtitulo);

        return $compraDataTable->render('compras.index');
    }

    /**
     * Show the form for creating a new Compra.
     *
     * @return Response
     */
    public function create()
    {
        $temporal = $this->compraTemporal();

        return view('compras.create',compact('temporal'));
    }

    /**
     * Store a newly created Compra in storage.
     *
     * @param CreateCompraRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraRequest $request)
    {
        $input = $request->all();

        /** @var Compra $compra */
        $compra = Compra::create($input);

        flash()->success('Compra guardado exitosamente.');

        return redirect(route('compras.index'));
    }

    /**
     * Display the specified Compra.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            flash()->error('Compra no encontrado');

            return redirect(route('compras.index'));
        }

        return view('compras.show')->with('compra', $compra);
    }

    /**
     * Show the form for editing the specified Compra.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            flash()->error('Compra no encontrado');

            return redirect(route('compras.index'));
        }

        return view('compras.edit')->with('compra', $compra);
    }

    /**
     * Update the specified Compra in storage.
     *
     * @param  int              $id
     * @param UpdateCompraRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraRequest $request)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            flash()->error('Compra no encontrado');

            return redirect(route('compras.index'));
        }

        try {
            DB::beginTransaction();

            $this->procesar($compra,$request);

        } catch (\Exception $exception) {

            DB::rollBack();

            if (auth()->user()->isDev()){
                throw $exception;
            }

            flash("Hubo un error intente de nuevo")->error();

            return redirect()->back();
        }

        DB::commit();

        flash('Listo! compra procesada.')->success();

        return redirect(route('compras.index'));
    }

    public function procesar(Compra $compra,UpdateCompraRequest $request){



        $request->merge([
            'estado_id' => CompraEstado::CREADA,
            'codigo' => $this->getCodigo(),
            'correlativo' => $this->getCorrelativo(),
        ]);

        $compra->fill($request->all());
        $compra->save();

        if ($request->ingreso_inmediato){
            $compra->procesaIngreso();
        }


        if($compra){
            //Mail::send(new OrdenCompra($compra));
        }

        return $compra;
    }

    /**
     * Remove the specified Compra from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            flash()->error('Compra no encontrado');

            return redirect(route('compras.index'));
        }

        $compra->delete();

        flash()->success('Compra deleted successfully.');

        return redirect(route('compras.index'));
    }

    public function compraTemporal()
    {

        $user = auth()->user();

        $compra = Compra::temporal()->delUsuarioCrea()->first();


        if (!$compra){

            $compra =  Compra::create([
                'usuario_crea' => $user->id,
                'estado_id' => CompraEstado::TEMPORAL,
            ]);
        }

        return $compra;
    }


    public function getCodigo($cantidadCeros = 1)
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

    public function anular(Compra $compra){

        try {
            DB::beginTransaction();

            $compra->anular();


        } catch (\Exception $exception) {
            DB::rollBack();

            errorException($exception);

            return redirect()->back();
        }


        DB::commit();


        flash()->success('Listo! compra anulada.');

        return redirect(route('compras.index'));
    }

    public function ingreso($id){


        try {
            DB::beginTransaction();

            $compra = Compra::with('detalles.item')->find($id);

            $compra->procesaIngreso();

        } catch (\Exception $exception) {
            DB::rollBack();

            manejarExcepcion($exception);

            return redirect()->back();
        }


        DB::commit();

        flash('Ingreso Realizado')->success();


        return redirect(route('compras.index'));

    }

    public function pdf(Compra $compra){

//        dd('este es el metodo que genera el pdf', $compra->toArray());

        $pdf = App::make('snappy.pdf.wrapper');

        $view = view('compras.pdf', compact('compra'))->render();
        $footer = view('compras.pdf_footer')->render();

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

    public function rptComprasDiarias(){

        $diasMes=diasMesActual();
        $recibidas = Cestado::RECIBIDA;

        $results = DB::select( DB::raw("
            select
                date(c.fecha_ingreso) dia,sum((d.cantidad* d.precio)) monto
            from
                compras c inner join compra_detalles d on c.id= d.compra_id
            where
                month(c.fecha_ingreso)=MONTH(CURDATE())
                and c.estado_id  in($recibidas)
                and c.deleted_at IS NULL
            group by
                1
        ") );

        return view('reportes.compras.rpt_compras_dia', compact('results'));
    }

}
