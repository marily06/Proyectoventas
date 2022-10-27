<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Venta
 * @package App\Models
 * @version August 23, 2022, 11:24 am CST
 *
 * @property TipoPago $tipoPago
 * @property Collection $detalles
 * @property Cliente $cliente
 * @property User $usuarioCrea
 * @property VentaEstado $estado
 * @property Collection $ventaDetalles
 * @property integer $cliente_id
 * @property string $fecha
 * @property string $fecha_entrega
 * @property number $recibido
 * @property number $monto_delivery
 * @property boolean $delivery
 * @property string $direccion
 * @property string $observaciones
 * @property string $nombre_entrega
 * @property string $telefono
 * @property string $correo
 * @property boolean $web
 * @property number $descuento
 * @property integer $estado_id
 * @property integer $tipo_pago_id
 * @property integer $user_id
 */
class Venta extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'ventas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'cliente_id',
        'fecha',
        'fecha_entrega',
        'hora_entrega',
        'recibido',
        'monto_delivery',
        'delivery',
        'direccion',
        'observaciones',
        'nombre_entrega',
        'telefono',
        'correo',
        'web',
        'descuento',
        'estado_id',
        'tipo_pago_id',
        'usuario_crea'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'fecha' => 'date',
        'fecha_entrega' => 'date',
        'recibido' => 'decimal:2',
        'monto_delivery' => 'decimal:2',
        'delivery' => 'boolean',
        'direccion' => 'string',
        'observaciones' => 'string',
        'nombre_entrega' => 'string',
        'telefono' => 'string',
        'correo' => 'string',
        'web' => 'boolean',
        'descuento' => 'decimal:2',
        'estado_id' => 'integer',
        'tipo_pago_id' => 'integer',
        'usuario_crea' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cliente_id' => 'required',
        'fecha' => 'nullable',
        'fecha_entrega' => 'nullable',
        'hora_entrega' => 'nullable',
        'recibido' => 'nullable|numeric',
        'monto_delivery' => 'nullable|numeric',
        'delivery' => 'nullable|boolean',
        'direccion' => 'nullable|string',
        'observaciones' => 'nullable|string',
        'nombre_entrega' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'correo' => 'nullable|string|max:255',
        'web' => 'nullable|boolean',
        'descuento' => 'nullable|numeric',
        'tipo_pago_id' => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoPago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'usuario_crea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estado()
    {
        return $this->belongsTo(VentaEstado::class, 'estado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class, 'venta_id');
    }

    public function scopeTemporal($q)
    {
        $q->where('estado_id',VentaEstado::TEMPORAL);
    }

    public function scopeDelUsuarioCrea($q,$user=null)
    {
        $user = $user ?? auth()->user() ?? auth('api')->user();


        $q->where('usuario_crea',$user->id);
    }

    public function scopeNoTemporal($q)
    {
        $q->where('estado_id','!=',VentaEstado::TEMPORAL);
    }

    public function getTotalAttribute()
    {
        return ($this->sub_total+$this->monto_delivery)- ($this->descuento_monto ?? 0);;
    }

    public function getDescuentoMontoAttribute()
    {
        return $this->sub_total * ($this->descuento/100);
    }

    public function getMontoDeliveryAttribute($monto)
    {
        return $this->delivery ? $monto : 0;
    }

    public function getSubTotalAttribute()
    {
        return $this->detalles->sum(function ($det){
            return $det->cantidad*$det->precio;
        });
    }

    public function procesaEgresoStock()
    {
        /**
         * @var VentaDetalle $detalle
         */
        foreach ($this->detalles as $detalle){

            $item = $detalle->item;
            $item->stock -= $detalle->cantidad;
            $item->save();

        }
    }

    public function anular()
    {
        $this->estado_id=VentaEstado::ANULADA;
        $this->save();

        /**
         * @var VentaDetalle $det
         */
        foreach ($this->detalles as $det){
            $item = $det->item;
            $item->stock +=  $det->cantidad;
            $item->save();
        }
    }

    public function scopeTipoPedido($query)
    {
        return $query->where('web',1)->whereNotIn('estado_id',[VentaEstado::ENTREGADA,VentaEstado::ANULADA,VentaEstado::TEMPORAL]);
    }

    public function puedePreparar()
    {
        return in_array($this->estado_id,[
            VentaEstado::PAGADA
        ]);
    }

    public function puedeLista()
    {
        return in_array($this->estado_id,[
            VentaEstado::PREPARANDO
        ]);
    }

    public function puedeDespachar()
    {
        return in_array($this->estado_id,[
            VentaEstado::LISTA
        ]);
    }


    public function puedeAnular()
    {
        return in_array($this->estado_id,[
            VentaEstado::PAGADA,
            VentaEstado::PREPARANDO,
            VentaEstado::LISTA,
            VentaEstado::ENTREGADA,
        ]);
    }
}
