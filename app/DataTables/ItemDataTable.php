<?php

namespace App\DataTables;

use App\Models\Item;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function(Item $item){

                 $id = $item->id;

                 return view('items.datatables_actions',compact('item','id'))->render();
            })
            ->editColumn('precio_compra',function ($data){
                return dvs().' '.nfp($data->precio_compra);

            })
            ->editColumn('marca.nombre',function (Item $item){
                return $item->marca->nombre ?? '';
            })
            ->editColumn('unimed.nombre',function (Item $item){
                return $item->unimed->nombre ?? '';
            })
            ->editColumn('imagen',function (Item $item){
                return "<img src='$item->miniatura' alt=\"\" class=\"img-responsive \" width='42' height='42'>";
            })
            ->rawColumns(['imagen','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Item $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        return $model->newQuery()->select('items.*')->with(['marca','unimed']);
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
            Column::make('imagen')->searchable(false)->orderable(false),
            Column::make('codigo'),
            Column::make('nombre'),
            Column::make('marca')->name('marca.nombre')->data('marca.nombre'),
            Column::make('U/M')->name('unimed.nombre')->data('unimed.nombre'),
            Column::make('stock'),
            Column::make('precio_venta'),
            Column::make('precio_compra'),
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
        return 'items_'  . date('YmdHis');
    }
}
