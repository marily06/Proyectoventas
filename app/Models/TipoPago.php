<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TipoPago
 * @package App\Models
 * @version August 23, 2022, 11:20 am CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $ventas
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $web
 * @property boolean $local
 * @property string $ruta_procesa
 * @property string $credenciales
 * @property string $icono
 */
class TipoPago extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tipo_pagos';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'descripcion',
        'web',
        'local',
        'ruta_procesa',
        'credenciales',
        'icono'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
        'descripcion' => 'string',
        'web' => 'boolean',
        'local' => 'boolean',
        'ruta_procesa' => 'string',
        'credenciales' => 'string',
        'icono' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
        'web' => 'required|boolean',
        'local' => 'required|boolean',
        'ruta_procesa' => 'nullable|string|max:255',
        'credenciales' => 'nullable|string',
        'icono' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class, 'tipo_pago_id');
    }
}
