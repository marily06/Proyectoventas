<?php

namespace App\DataTables\Scopes;

use Carbon\Carbon;
use Yajra\DataTables\Contracts\DataTableScope;

class ScopeVentaDataTable implements DataTableScope
{


    public $cliente;
    public $del;
    public $al;
    public $item;
    public $usuario;
    public $estado;
    public $tienda;
    public $codigo;

    public function __construct()
    {

        $this->del = request()->del ?? null;
        $this->al = request()->al ?? null;
        $this->cliente = request()->cliente_id ?? null;
        $this->item = request()->item_id ?? null;
        $this->usuario = request()->usuario ?? null;
        $this->estado = request()->estado ?? null;
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
        if(!is_null($this->cliente)){
            $query->where('cliente_id', $this->cliente);
        }


        if(!is_null($this->item)){
            $query->whereIn('id', function($q) {
                $q->select('venta_id')->from('venta_detalles')->where('item_id',$this->item);
            });
        }

        if(!is_null($this->estado)){
            $query->where('vestado_id', $this->estado);
        }


        if($this->codigo){

            list($tipo,$year,$correlativo)=explode('-',$this->codigo);

            $query->where('correlativo',$correlativo)->whereYear('created_at', $year);
        }

        if($this->usuario){
            if(is_array($this->usuario)){
                $query->whereIn('user_id', $this->usuario);
            }else{
                $query->where('user_id', $this->usuario);
            }
        }

        if($this->del && $this->al){

            $del = Carbon::parse($this->del);
            $al = Carbon::parse($this->al)->addDay(1);

            $query->whereBetween('ventas.created_at',[$del,$al]);
        }

        return $query;
    }
}
