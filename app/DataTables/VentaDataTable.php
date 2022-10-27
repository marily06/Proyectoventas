<?php

namespace App\DataTables;

use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use App\extensiones\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VentaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', function (Venta $venta){

                $id = $venta->id;

                return view('ventas.datatables_actions',compact('venta','id'));

            })

            ->editColumn('id',function (Venta $venta){
                return view('ventas.modal_detalles',compact('venta'))->render();
            })
            ->editColumn('cliente.nombres',function (Venta $venta){
                return $venta->cliente->nombre_completo;
            })
            ->editColumn('user.name',function (Venta $venta){
                return $venta->usuarioCrea->name ?? 'C/F';
            })
            ->editColumn('fecha',function (Venta $venta){
                return fechaLtn($venta->fecha);
            })
            ->rawColumns(['action','id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Venta $model)
    {
        $user = Auth::user();

        $query =  $model->newQuery()
            ->whereHas('detalles',function ($q){
                $q->whereHas('item');
            })
            ->with(['detalles.item','cliente','tipoPago','usuarioCrea','estado']);

//        //Usuario normal o empleado solo las compras realizadas por el
//        if ($user->cannot('ver todas las ventas')){
//            $query->delUsuarioCrea();
//        }

        return $query;

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->ajax([
                'data' => "function(data) { formatDataDataTables($('#form-filter-ventas').serializeArray(), data);   }"
            ])
            ->addAction(['width' => '15%','printable' => false, 'title' => 'Acción'])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'language' => ['url' => asset('js/SpanishDataTables.json')],
                //'scrollX' => false,
                'stateSave' => true,
                'responsive' => true,
                'buttons' => [
                    ['extend' => 'create', 'text' => '<i class="fa fa-plus"></i> <span class="d-none d-sm-inline">Crear</span>'],
                    ['extend' => 'print', 'text' => '<i class="fa fa-print"></i> <span class="d-none d-sm-inline">Imprimir</span>'],
                    ['extend' => 'reload', 'text' => '<i class="fa fa-sync-alt"></i> <span class="d-none d-sm-inline">Recargar</span>'],
                    ['extend' => 'reset', 'text' => '<i class="fa fa-undo"></i> <span class="d-none d-sm-inline">Reiniciar</span>'],
                    ['extend' => 'export', 'text' => '<i class="fa fa-download"></i> <span class="d-none d-sm-inline">Exportar</span>'],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['name' => 'id', 'data' => 'id'],
            'cliente_nombre' => ['name' => 'cliente.nombres', 'data' => 'cliente.nombres','visible' => false],
            'cliente' => ['name' => 'cliente.nombres', 'data' => 'cliente.nombres'],
            'fecha' => ['name' => 'fecha', 'data' => 'fecha'],
            'estado' => ['name' => 'estado.nombre', 'data' => 'estado.nombre'],
            'tipo_pago' => ['name' => 'tipoPago.nombre', 'data' => 'tipo_pago.nombre'],
            'usuario' => ['name' => 'user.name', 'data' => 'user.name'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ventasdatatable_' . time();
    }

}
