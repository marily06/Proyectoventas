<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cliente
 * @package App\Models
 * @version January 8, 2021, 9:30 am CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $ventas
 * @property string $nit
 * @property string $dpi
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefono
 * @property string $telefono2
 * @property string $email
 * @property string $genero
 * @property string $fecha_nacimiento
 * @property string $direccion
 * @property string nombre_completo
 */
class Cliente extends Model
{
    use SoftDeletes,HasFactory;

    public $table = 'clientes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const CF = 1;

    protected $dates = ['deleted_at'];
    protected $appends = ['nombre_completo','correo'];


    public $fillable = [
        'nit',
        'dpi',
        'nombres',
        'apellidos',
        'telefono',
        'telefono2',
        'email',
        'genero',
        'fecha_nacimiento',
        'direccion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nit' => 'string',
        'dpi' => 'string',
        'nombres' => 'string',
        'apellidos' => 'string',
        'telefono' => 'string',
        'email' => 'string',
        'genero' => 'string',
        //'fecha_nacimiento' => 'date',
        'direccion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nit' => 'nullable|string|max:10',
        'dpi' => 'nullable|string|max:13',
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'telefono' => 'nullable|string|max:20',
        'telefono2' => 'nullable|string|max:20',
        'email' => 'nullable|string|max:100',
        'genero' => 'required|string',
        'fecha_nacimiento' => 'nullable',
        'direccion' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ventas()
    {
        return $this->hasMany(\App\Models\Venta::class,'cliente_id','id');
    }

    public function getNombreCompletoAttribute(){
        return $this->attributes['nombres'].' '.$this->attributes['apellidos'];
    }

    public function getFechaNacimientoAttribute($d)
    {
        return fechaLtn($d);
    }

    public function getCorreoAttribute()
    {
        return $this->email;
    }
}
