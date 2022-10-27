<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VentaDetalle
 * @package App\Models
 * @version August 24, 2022, 3:18 pm CST
 *
 * @property \App\Models\Item $item
 * @property \App\Models\Venta $venta
 * @property integer $venta_id
 * @property integer $item_id
 * @property number $cantidad
 * @property number $precio
 * @property number $descuento
 */
class VentaDetalle extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'venta_detalles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends =['sub_total'];

    public $fillable = [
        'venta_id',
        'item_id',
        'cantidad',
        'precio',
        'descuento'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'venta_id' => 'integer',
        'item_id' => 'integer',
        'cantidad' => 'decimal:2',
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'venta_id' => 'required',
        'item_id' => 'required',
        'cantidad' => 'required|numeric',
        'precio' => 'required|numeric',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function item()
    {
        return $this->belongsTo(\App\Models\Item::class, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function venta()
    {
        return $this->belongsTo(\App\Models\Venta::class, 'venta_id');
    }

    public function getSubTotalAttribute()
    {
        return ($this->cantidad*$this->precio);
    }
}
