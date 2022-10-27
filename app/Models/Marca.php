<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Marca
 * @package App\Models
 * @version July 27, 2022, 12:21 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection $items
 * @property string $nombre
 * @property string $thumb
 */
class Marca extends Model  implements HasMedia
{
    use SoftDeletes,InteractsWithMedia;

    use HasFactory;

    public $table = 'marcas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


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
        'nombre' => 'required|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function items()
    {
        return $this->hasMany(\App\Models\Item::class, 'marca_id');
    }

    public function getImgAttribute()
    {
        $media = $this->getMedia('marcas')->first();
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
        $media = $this->getMedia('marcas')->first();
        return $media ? $media->getUrl('thumb') : asset('img/default.svg');
    }
}
