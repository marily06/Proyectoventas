<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CompraEstado
 * @package App\Models
 * @version July 27, 2022, 12:20 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $compras
 * @property string $nombre
 */
class CompraEstado extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'compra_estados';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    const TEMPORAL =   1;
    const CREADA =     2;
    const RECIBIDA =   3;
    const CANCELADA =  4;
    const ANULADA =    5;

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:45',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function compras()
    {
        return $this->hasMany(\App\Models\Compra::class, 'estado_id');
    }
}
