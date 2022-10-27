<?php

namespace App\DataTables;

use App\Models\CompraEstado;
use App\Models\Compra;
use App\Models\VistaCompra;
use App\extensiones\DataTable;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CompraDataTable extends DataTable
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

        return $dataTable
            ->addColumn('action', function (Compra $compra){
                $id = $compra->id;

                return view('compras.datatables_actions',compact('compra','id'));
            })
            ->editColumn('fecha_documento',function (Compra $compra){
                return fechaLtn($compra->fecha_documento);
            })

            ->editColumn('fecha_ingreso',function (Compra $compra){
                return fechaLtn($compra->fecha_ingreso);
            })

            ->editColumn('total',function (Compra $compra){
                return dvs().nfp($compra->total);
            })
//            ->setRowClass(function ($data) {
//
//                $alert = '';
//
//                if(hoyDb()>$data->fecha_ingreso_plan && $data->estado->id == CompraEstado::CREADA ){
//                    $alert = 'alert-danger';
//                }
//                elseif(hoyDb() == $data->fecha_ingreso_plan  && $data->estado->id == CompraEstado::CREADA ){
//                    $alert = 'alert-warning';
//                }
//
//                return $alert;
//
//            })
            ->with([
                'totalFilter' => function() use ($dataTable){
                    return dvs().nfp($dataTable->results()->sum('total'));
                },
                'count_rows' => function() use ($dataTable){
                    return $dataTable->results()->count();
                }

            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Compra $model)
    {

        $query = $model->newQuery()
            ->select('compras.*')
            ->noTemporal()
            ->with(['detalles.item','tipo','usuarioCrea','estado','proveedor']);

        $user = Auth::user();


        //Usuario normal o empleado solo las compras realizadas por el
        if ($user->cannot('ver todas las compras')){
            $query->delUsuarioCrea();
        }

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
                'data' => "function(data) { formatDataDataTables($('#formFiltersDatatables').serializeArray(), data);   }"
            ])
            ->info(true)
            ->language(['url' => asset('js/SpanishDataTables.json')])
            ->responsive(true)
            ->orderBy(1,'desc')
            ->stateSave(true)
            ->dom('
                        <"row mb-2"
                            <"col-sm-12 col-md-6" B>
                            <"col-sm-12 col-md-6" f>
                        >
                        rt
                        <"row"
                            <"col-sm-6 order-2 order-sm-1" ip>
                            <"col-sm-6 order-1 order-sm-2 text-right" l>

                        >
                    ')
            ->buttons(

                Button::make('print')
                    ->text('<i class="fa fa-print"></i> <span class="d-none d-sm-inline">Imprimir</span>'),
                Button::make('reset')
                    ->text('<i class="fa fa-undo"></i> <span class="d-none d-sm-inline">Reiniciar</span>'),
                Button::make('export')
                    ->text('<i class="fa fa-download"></i> <span class="d-none d-sm-inline">Exportar</span>'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('codigo'),
            Column::make('fecha_documento'),
            Column::make('fecha_ingreso'),
            Column::make('tipo')
                    ->data('tipo.nombre')
                    ->name('tipo.nombre'),
            Column::make('proveedor')
                    ->data('proveedor.nombre')
                    ->name('proveedor.nombre'),
            Column::make('estado')
                    ->data('estado.nombre')
                    ->name('estado.nombre'),
            Column::make('usuario')
                    ->data('usuario_crea.name')
                    ->name('usuarioCrea.name'),
            Column::make('total'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width('15%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'reporte_compras_' . time();
    }
}
