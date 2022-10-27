<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class ItemCategoria
 * @package App\Models
 * @version July 27, 2022, 12:21 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $items
 * @property \Illuminate\Database\Eloquent\Collection $item1s
 * @property string $nombre
 * @property string $descripcion
 * @property string $thumb
 */
class ItemCategoria extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;

    use HasFactory;

    public $table = 'item_categorias';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'descripcion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
        'descripcion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|string|max:45',
        'descripcion' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function items()
    {
        return $this->belongsToMany(\App\Models\Item::class, 'item_has_categoria','categoria_id','item_id');
    }


    public function getImgAttribute()
    {
        $media = $this->getMedia('categorias')->first();
        return $media ? $media->getUrl() : asset('img/default.svg');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(270)
            ->height(135);
    }

    public function getThumbAttribute()
    {
        $media = $this->getMedia('categorias')->first();
        return $media ? $media->getUrl('thumb') : asset('img/default.svg');
    }

    public function scopeConItemsWeb($q)
    {
        $q->whereHas('items',function ($item){
            $item->web();
        });
    }
}
