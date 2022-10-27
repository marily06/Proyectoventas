<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Proveedor
 * @package App\Models
 * @version July 27, 2022, 12:20 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $compras
 * @property string $nit
 * @property string $nombre
 * @property string $razon_social
 * @property string $correo
 * @property string $telefono_movil
 * @property string $telefono_oficina
 * @property string $direccion
 * @property string $observaciones
 */
class Proveedor extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'proveedores';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nit',
        'nombre',
        'razon_social',
        'correo',
        'telefono_movil',
        'telefono_oficina',
        'direccion',
        'observaciones'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nit' => 'string',
        'nombre' => 'string',
        'razon_social' => 'string',
        'correo' => 'string',
        'telefono_movil' => 'string',
        'telefono_oficina' => 'string',
        'direccion' => 'string',
        'observaciones' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nit' => 'nullable|string|max:10',
        'nombre' => 'required|string|max:45',
        'razon_social' => 'nullable|string|max:255',
        'correo' => 'nullable|string|max:100',
        'telefono_movil' => 'nullable|string|max:8',
        'telefono_oficina' => 'nullable|string|max:8',
        'direccion' => 'nullable|string',
        'observaciones' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function compras()
    {
        return $this->hasMany(\App\Models\Compra::class, 'proveedor_id');
    }
}
