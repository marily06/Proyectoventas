<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Item
 * @package App\Models
 * @version March 24, 2020, 10:34 am CST
 *
 * @property \App\Models\Marca $marca
 * @property \App\Models\Unimed $unimed
 * @property \App\Models\ItemCategoria $categoria
 * @property \Illuminate\Database\Eloquent\Collection $comentarios
 * @property \Illuminate\Database\Eloquent\Collection $compraDetalles
 * @property \Illuminate\Database\Eloquent\Collection $itemComentarios
 * @property \Illuminate\Database\Eloquent\Collection $categorias
 * @property \Illuminate\Database\Eloquent\Collection $ventaDetalles
 * @property string $nombre
 * @property string $descripcion
 * @property string $especificaciones
 * @property string $codigo
 * @property number $precio_venta
 * @property number $precio_compra
 * @property number $stock
 * @property string $ubicacion
 * @property boolean $inventariable
 * @property boolean $perecedero
 * @property boolean $web
 * @property integer $marca_id
 * @property integer $unimed_id
 * @property integer $categoria_id
 * @property string miniatura
 * @property string img
 */
class Item extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia,HasFactory;

    public $table = 'items';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends= ['text','img','miniatura','calificacion_total','sub_total'];

    protected $with = ['unimed','marca','media','comentarios'];

    public static $withoutAppends = false;

    public function scopeWithoutAppends($query)
    {
        self::$withoutAppends = true;

        return $query;
    }

    protected function getArrayableAppends()
    {
        if (self::$withoutAppends){
            return [];
        }

        return parent::getArrayableAppends();
    }

    public $fillable = [
        'nombre',
        'descripcion',
        'especificaciones',
        'codigo',
        'precio_venta',
        'precio_compra',
        'stock',
        'ubicacion',
        'inventariable',
        'perecedero',
        'web',
        'portada',
        'marca_id',
        'unimed_id',
        'categoria_id'
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
        'especificaciones' => 'string',
        'codigo' => 'string',
        'precio_venta' => 'decimal:2',
        'precio_compra' => 'decimal:2',
        'stock' => 'decimal:2',
        'ubicacion' => 'string',
        'inventariable' => 'boolean',
        'perecedero' => 'boolean',
        'web' => 'boolean',
        'marca_id' => 'integer',
        'unimed_id' => 'integer',
        'categoria_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
        'especificaciones' => 'nullable|string',
        'codigo' => 'nullable|string|max:25',
        'precio_venta' => 'required|numeric',
        'precio_compra' => 'required|numeric',
        'stock' => 'required|numeric',
        'ubicacion' => 'nullable|string|max:255',
        'inventariable' => 'nullable|boolean',
        'perecedero' => 'nullable|boolean',
        'web' => 'nullable|boolean',
        'marca_id' => 'nullable',
        'unimed_id' => 'nullable',
        'categoria_id' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];



    /**
     *RELACIONES
     */


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function marca()
    {
        return $this->belongsTo(\App\Models\Marca::class, 'marca_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function unimed()
    {
        return $this->belongsTo(\App\Models\Unimed::class, 'unimed_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function categoria()
    {
        return $this->belongsTo(\App\Models\ItemCategoria::class, 'categoria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function compraDetalles()
    {
        return $this->hasMany(\App\Models\CompraDetalle::class, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function comentarios()
    {
        return $this->hasMany(\App\Models\ItemComentario::class, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function categorias()
    {
        return $this->belongsToMany(\App\Models\ItemCategoria::class, 'item_has_categoria','item_id','categoria_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ventaDetalles()
    {
        return $this->hasMany(\App\Models\VentaDetalle::class, 'item_id');
    }



    /**
     *MÉTODOS Y MUTADORES
     */

    /**
     * Verifica si el item esta en el detalle de una compra
     * @return bool
     */
    public function estaEnUnaCompra(){

        return $this->getEntradasStock() > 0 ? true : false;
    }

    /**
     * Verifica si el item esta en el detalle de una venta
     * @return bool
     */
    public function estaEnUnaVenta(){

        return $this->getSalidasStock() > 0 ? true : false;
    }

    public function getTextAttribute()
    {
        $codigo = $this->codigo ? $this->codigo : 'sin codigo';
        return $codigo.' / '.$this->nombre;
    }

    public function img($conversion,$primera=0)
    {

        $media = $this->getMedia('items')->last();

        if ($primera){
            $media = $this->getMedia('items')->first();
        }

        return $media ? $media->getUrl($conversion) : asset('img/default.svg');
    }

    public function getImgAttribute()
    {
        $media = $this->getMedia('items')->last();
        return $media ? $media->getUrl('382x450') : asset('img/default.svg');
    }


    public function getMiniaturaAttribute()
    {
        $media = $this->getMedia('items')->first();
        return $media ? $media->getUrl('82x82') : asset('img/default.svg');
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this->addMediaConversion('1920x800')
            ->fit(Manipulations::FIT_CROP,1920,800);

        $this->addMediaConversion('1920x400')
            ->fit(Manipulations::FIT_CROP,1920,400);

        $this->addMediaConversion('600x470')
            ->fit(Manipulations::FIT_CROP,600,470);

        $this->addMediaConversion('382x450')
            ->fit(Manipulations::FIT_CROP,382,450);

        $this->addMediaConversion('370x400')
            ->fit(Manipulations::FIT_CROP,370,400);

        $this->addMediaConversion('376x448')
            ->fit(Manipulations::FIT_CROP,376,448);

        $this->addMediaConversion('302x323')
            ->fit(Manipulations::FIT_CROP,302,323);

        $this->addMediaConversion('270x430')
            ->fit(Manipulations::FIT_CROP,270,430);

        $this->addMediaConversion('82x82')
            ->fit(Manipulations::FIT_CROP,82,82);
    }


    public function relacionados($cantidad)
    {

        $items = Item::whereHas('categorias',function ($q){

            $q->whereIn('id',$this->categorias->pluck('id'));

        })->whereNotIn('id',[$this->id])->with(['media'])->web()->get();

        return $items->count() > 1 ? $items->random($cantidad) : $items->random($items->count());
    }

    public function getCalificacionTotalAttribute()
    {
        $totalComentarios = $this->comentarios->count();
        $totalCalificacion = $this->comentarios->sum('rating');

        if ($totalComentarios > 0){

            return round($totalCalificacion / $totalComentarios,1);
        }

        return 0;
    }



    /**
     *SCOPES
     */



    public function scopeDeCategoria($query,$categoria)
    {
        return $query->whereHas('categorias',function (Builder $q) use ($categoria){
            $q->where('id',$categoria);
        });
    }

    public function scopeDeMarca($query,$marca)
    {
        return $query->where('marca_id', $marca);
    }

    public function estaEnOferta()
    {
        return $this->descuentos->count()>0;
    }

    public function esNuevo()
    {
        $crado = Carbon::parse($this->created_at);

        return config('app.dias_producto_es_nuevo') >= Carbon::now()->diffInDays($crado);
    }

    public function getEntradasStock()
    {
        $ingresos = $this->compraDetalles->filter(function ($det){


            /**
             * @var CompraDetalle $det
             */
            if ($det->compra->cestado_id==Cestado::RECIBIDA){
                return $det;
            }
        });

        return $ingresos->sum('cantidad');
    }

    public function getSalidasStock()
    {

        $egresos = $this->ventaDetalles->filter(function ($det){


            /**
             * @var VentaDetalle $det
             */
            if ($det->venta->vestado_id!=Cestado::ANULADA){
                return $det;
            }
        });

        return $egresos->sum('cantidad');

    }

    public function puedeEditarNombre()
    {
        return !$this->estaEnUnaCompra() && !$this->estaEnUnaVenta();
    }

    public function puedeEditarStock()
    {
        return !$this->estaEnUnaCompra() && !$this->estaEnUnaVenta();
    }

    public function scopeWeb(Builder $q)
    {
        return $q->where('web',1);
    }

    public function scopePortada(Builder $q)
    {
        return $q->where('portada',1);
    }

    public function getSubTotalAttribute()
    {
        return ($this->cantidad ?? 0) * $this->precio_venta;
    }
}
