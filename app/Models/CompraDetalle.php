<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CompraDetalle
 * @package App\Models
 * @version July 27, 2022, 12:22 pm CST
 *
 * @property Compra $compra
 * @property Item $item
 * @property integer $compra_id
 * @property integer $item_id
 * @property number $cantidad
 * @property number $precio
 * @property number $descuento
 * @property string $fecha_vence
 */
class CompraDetalle extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'compra_detalles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends =['sub_total'];

    public $fillable = [
        'compra_id',
        'item_id',
        'cantidad',
        'precio',
        'descuento',
        'fecha_vence'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'compra_id' => 'integer',
        'item_id' => 'integer',
        'cantidad' => 'decimal:2',
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'fecha_vence' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'compra_id' => 'required',
        'item_id' => 'required',
        'cantidad' => 'required|numeric',
        'precio' => 'required|numeric',
        'descuento' => 'nullable|numeric',
        'fecha_vence' => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'ingresos')->withPivot('cantidad');
    }

    public function getSubTotalAttribute()
    {
        return $this->precio * $this->cantidad;
    }

    public function kardex()
    {
        return $this->morphOne(Kardex::class,'model');
    }

    public function getCodigoAttribute()
    {
        $codigo = $this->compra->codigo;

//        if ($this->compra->serie && $this->compra->numero){
//            $codigo = $this->compra->serie.' / '.$this->compra->numero;
//        }

        return $codigo;
    }

    public function getResponsableAttribute()
    {
        $codigo = $this->compra->proveedor->nombre;


        return $codigo;
    }

    public function ingreso()
    {

        if(!$this->item->inventariable)
            return null;

        $item = $this->item;
        $item->stock += $this->cantidad;
        $item->save();

    }

    public function anular()
    {
        $item = $this->item;
        $item->stock -= $this->cantidad;
        $item->save();
    }
}
