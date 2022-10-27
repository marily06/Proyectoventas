<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Option
 * @package App\Models
 * @version September 21, 2021, 3:53 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $roles
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property integer $option_id
 * @property string $nombre
 * @property string $ruta
 * @property string $descripcion
 * @property string $icono_l
 * @property string $icono_r
 * @property integer $orden
 * @property string $color
 * @property boolean $dev
 */
class Option extends Model
{

    use SoftDeletes;

    public $table = 'options';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const PANEL_DE_CONTROL = 1;
    const PEDIDOS = 2;
    const NUEVA_VENTA = 3;
    const COMPRAS = 4;
    const NUEVA_COMPRA = 5;
    const BUSCAR_COMPRAS = 6;
    const PROVEEDORES = 7;
    const COMPRA_ESTADOS = 8;
    const TIPOS = 9;
    const VENTAS = 10;
    const BUSCAR_VENTA = 11;
    const VENTA_ESTADOS = 12;
    const CLIENTES = 13;
    const TIPOS_DE_PAGO = 14;
    const ARTICULOS = 15;
    const BUSCAR_ARTICULO = 16;
    const NUEVO_ARTICULO = 17;
    const IMPORTAR_EXCEL = 18;
    const CATEGORIAS = 19;
    const UNIDADES_DE_MEDIDA = 20;
    const MARCAS = 21;
    const ADMIN = 22;
    const USUARIOS = 23;
    const ROLES = 24;
    const PERMISOS = 25;
    const CONFIGURACIONES_USER = 26;
    const DEVELOPER = 27;
    const PRUEBA_APIS = 28;
    const CONFIGURACIONES_DEV = 29;
    const MENU = 30;
    const ECOMMERCE = 31;


    protected $appends = ['active','visible_to_user','text','ruta_evaluada'];

    public $fillable = [
        'option_id',
        'nombre',
        'ruta',
        'descripcion',
        'icono_l',
        'icono_r',
        'orden',
        'color',
        'dev'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'option_id' => 'integer',
        'nombre' => 'string',
        'ruta' => 'string',
        'descripcion' => 'string',
        'icono_l' => 'string',
        'icono_r' => 'string',
        'orden' => 'integer',
        'color' => 'string',
        'dev' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
        'ruta' => 'required',
        'icono_l' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'option_role');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'option_user');
    }

    public function parent()
    {
        return $this->belongsTo(Option::class,'option_id','id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(Option::class,'option_id','id')->orderBy('orden')->with('children');
    }

    public function hasChildren()
    {
        return $this->children->count()>0;
    }

    public function hasTreeview()
    {
        return $this->hasChildren() ? 'has-treeview' : '';
    }

    public function active()
    {
        if (!$this->ruta){
            return '';
        }
        return request()->route()->getName() == $this->ruta ? 'active' : '';
    }

    public function openTreeView($children=null)
    {

        return $this->allDescendant()->contains('active','active') ? 'menu-open' : '';

    }

    public function allDescendant($children=null,$all=null)
    {
        $all = $all ?? collect();

        $children = $children ?? $this->children;

        foreach ($children as $child){
            $all = $all->push($child);
            if ($child->children->count()>0){
                $this->allDescendant($child->children,$all);
            }
        }

        return $all;
    }

    public function getActiveAttribute()
    {
        return $this->active();
    }

    public function getVisibleToUserAttribute()
    {
        if (Auth::user()){

            return is_null($this->option_id) || Auth::user()->getAllOptions()->contains('id',$this->id);
        }

        return false;
    }

    public function scopePadres($query)
    {
        return $query->whereNull('options.option_id')->orderBy('orden');
    }

    public function scopePadresDe($query,$chidres)
    {
        return $query->whereHas('children',function ($q)use ($chidres){
            $q->whereIn('id',$chidres);
        });
    }

    public function isChildren()
    {
        return !is_null($this->option_id);
    }

    public function getTextAttribute()
    {
        return $this->nombre;
    }

    public function getRutaEvaluadaAttribute()
    {
        return rutaOpcion($this);
    }
}
