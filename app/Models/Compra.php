<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Compra
 * @package App\Models
 * @version July 27, 2022, 12:21 pm CST
 *
 * @property \App\Models\User $usuarioCrea
 * @property \App\Models\Proveedor $proveedor
 * @property \App\Models\CompraTipo $tipo
 * @property \App\Models\User $usuarioRecibe
 * @property \App\Models\CompraEstado $estado
 * @property \Illuminate\Database\Eloquent\Collection $compra1hs
 * @property \Illuminate\Database\Eloquent\Collection $detalles
 * @property integer $tipo_id
 * @property integer $proveedor_id
 * @property string $codigo
 * @property integer $correlativo
 * @property string $fecha_documento
 * @property string $fecha_ingreso
 * @property string $serie
 * @property string $numero
 * @property integer $estado_id
 * @property integer $usuario_crea
 * @property integer $usuario_recibe
 * @property string $observaciones
 */
class Compra extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'compras';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipo_id',
        'proveedor_id',
        'codigo',
        'correlativo',
        'fecha_documento',
        'fecha_ingreso',
        'serie',
        'numero',
        'estado_id',
        'usuario_crea',
        'usuario_recibe',
        'observaciones'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tipo_id' => 'integer',
        'proveedor_id' => 'integer',
        'codigo' => 'string',
        'correlativo' => 'integer',
        'fecha_documento' => 'date',
        'fecha_ingreso' => 'date',
        'serie' => 'string',
        'numero' => 'string',
        'estado_id' => 'integer',
        'usuario_crea' => 'integer',
        'usuario_recibe' => 'integer',
        'observaciones' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tipo_id' => 'required',
        'proveedor_id' => 'required',
        'codigo' => 'nullable|string|max:45',
        'correlativo' => 'nullable|integer',
        'fecha_documento' => 'nullable',
        'fecha_ingreso' => 'nullable',
        'serie' => 'nullable|string|max:45',
        'numero' => 'nullable|string|max:20',
        'estado_id' => 'nullable',
        'usuario_crea' => 'nullable',
        'usuario_recibe' => 'nullable',
        'observaciones' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usuarioCrea()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_crea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function proveedor()
    {
        return $this->belongsTo(\App\Models\Proveedor::class, 'proveedor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipo()
    {
        return $this->belongsTo(\App\Models\CompraTipo::class, 'tipo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function usuarioRecibe()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_recibe');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estado()
    {
        return $this->belongsTo(\App\Models\CompraEstado::class, 'estado_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function compra1hs()
    {
        return $this->hasMany(\App\Models\Compra1h::class, 'compra_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class,'compra_id','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'compra_venta');
    }


    public function getTotalAttribute()
    {
        return $this->sub_total - ($this->descuento_monto ?? 0);
    }



    public function scopeDelUser($query,$user=null)
    {
        $user = $user ?? auth()->user()->id ?? null;

        if ($user){

            return $query->where('user_id',$user);
        }

        return $query;
    }


    public function getSubTotalAttribute()
    {
        return $this->detalles->sum(function ($det){
            return $det->cantidad*$det->precio;
        });
    }

    public function getTotalVentaAttribute()
    {

        return $this->detalles->sum(function ($det){
            return $det->cantidad*$det->item->precio_venta;
        });

    }


    public function procesaIngreso()
    {

        /**
         * @var CompraDetalle $detalle
         */
        foreach ($this->detalles as $detalle){
            $detalle->ingreso();
        }

        $this->estado_id = CompraEstado::RECIBIDA;
        $this->fecha_ingreso = hoyDb();
        $this->save();

    }

    public function scopeDelItem($query,$item)
    {
        return $query->whereIn('id', function($q) use ($item){
            $q->select('compra_id')->from('compra_detalles')->where('item_id',$item);
        });
    }

    public function scopeTemporal($q)
    {
        $q->where('estado_id',CompraEstado::TEMPORAL);
    }

    public function scopeDelUsuarioCrea($q,$user=null)
    {
        $user = $user ?? auth()->user() ?? auth('api')->user();


        $q->where('usuario_crea',$user->id);
    }

    public function scopeNoTemporal($q)
    {
        $q->where('estado_id','!=',CompraEstado::TEMPORAL);
    }


    public function anular()
    {
        $this->estado_id = CompraEstado::ANULADA;
        $this->save();


        /**
         * @var CompraDetalle $detalle
         */
        foreach ($this->detalles as $detalle){
            $detalle->anular();
        }
    }
}
