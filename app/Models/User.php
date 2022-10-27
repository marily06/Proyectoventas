<?php

namespace App\Models;

use App\Models\Option;
use App\Models\Role;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    use HasRoles;
    use InteractsWithMedia;
    use HasFactory;


    const PRINCIPAL = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password','provider','provider_uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'     => 'required|max:255',
        'username' => 'sometimes|required|max:255|unique:users',
        'email'    => 'sometimes|required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
    ];


    public function scopeNoClientes($query){
        return $query->whereHas('roles',function ($q){
            $q->where('id','!=',Role::CLIENTE);
        })->orWhereDoesntHave('roles');
    }

    public function scopeAdmins($query){
        return $query->role(Role::ADMIN);
    }

    public function opciones(){
        return $this->belongsToMany(Option::class);
    }

    public function options(){
        return $this->belongsToMany(Option::class);
    }


    public function isAdmin(){

        return $this->hasRole(Role::ADMIN);
    }

    public function isDev(){

        return $this->hasRole(Role::DEVELOPER);
    }

    public function isSuperAdmin(){

        return $this->hasRole(Role::SUPERADMIN);
    }


    public function ventas()
    {
        return $this->hasMany(Venta::class,'usuario_crea');
    }

    public function getImgAttribute()
    {
        $media = $this->getMedia('avatars')->last();
        return $media ? $media->getUrl() : asset('img/avatar5.png');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public function getThumbAttribute()
    {
        $media = $this->getMedia('avatars')->last();
        return $media ? $media->getUrl('thumb') : asset('img/avatar5.png');
    }

    public function shortcuts()
    {
        return $this->belongsToMany(Option::class,'user_shortcuts','user_id','option_id');
    }

    public function getAllOptions()
    {
        $opcionesDirectas = $this->options;

        $opcionesPorRol = collect();


        /**
         * @var Role $role
         */
        foreach ($this->roles as $index => $role) {
            $opcionesPorRol = $opcionesPorRol->merge($role->options);
        }

        $allOptions = $opcionesDirectas->merge($opcionesPorRol);


//        dd($this->id,$opcionesDirectas->toArray(),$opcionesPorRol->toArray(),$allOptions->toArray());

        return $allOptions;
    }

}
