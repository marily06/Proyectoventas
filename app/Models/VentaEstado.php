<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class VentaEstado
 * @package App\Models
 * @version August 23, 2022, 11:20 am CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $ventas
 * @property string $descripcion
 * @property boolean $orden
 */
class VentaEstado extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'venta_estados';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    const TEMPORAL =        1;
    const PAGADA =          2;
    const PREPARANDO =      3;
    const LISTA =           4;
    const ENTREGADA =       5;
    const ANULADA =         6;

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'orden'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
        'orden' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:255',
        'orden' => 'required|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class, 'estado_id');
    }
}
