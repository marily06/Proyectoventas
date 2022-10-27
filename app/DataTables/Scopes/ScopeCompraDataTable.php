<?php

namespace App\DataTables\Scopes;

use Carbon\Carbon;
use Yajra\DataTables\Contracts\DataTableScope;

class ScopeCompraDataTable implements DataTableScope
{


    public $codigo;
    public $proveedores;
    public $items;
    public $estados;
    public $del;
    public $al;

    public function __construct()
    {

        $this->proveedores = request()->proveedores ?? null;
        $this->del = request()->del ?? null;
        $this->al = request()->al ?? null;
        $this->items = request()->items ?? null;
        $this->estados = request()->estados ?? null;
        $this->between = request()->between ?? null;
        $this->codigo = request()->codigo ?? null;

    }


    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {

        if($this->codigo){
            $query->where('codigo','like',"%$this->codigo%");
        }

        if($this->proveedores){
            if (is_array($this->proveedores)){
                $query->whereIn('proveedor_id', $this->proveedores);
            }else{
                $query->where('proveedor_id', $this->proveedores);
            }
        }

        if($this->items){
            $query->whereHas('detalles', function ($queryDetalles) {
                if (is_array($this->items)){
                    $queryDetalles->whereIn('item_id', $this->items);
                }else{
                    $queryDetalles->where('item_id', $this->items);
                }
            });
        }


        if($this->estados){
            if (is_array($this->estados)){
                $query->whereIn('estado_id', $this->estados);
            }else{
                $query->where('estado_id', $this->estados);
            }
        }

        if ($this->del && $this->al){

            $del = Carbon::parse($this->del)->startOfDay();
            $al = Carbon::parse($this->al)->endOfDay();

            $query->whereBetween('created_at',[$del,$al]);

        }



        return $query;
    }
}
