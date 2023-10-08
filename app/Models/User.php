<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//spatie
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //En caso que le pongamos imagen al usuario se 
    //debe de usar este metodo para recuperarlo de la base

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    //aqui hay que recuperar el rol del usuario
    public function adminlte_desc()
    {
        return 'Recupere el nombre del rol';
    }

    //acceder al perfil del usuario
    public function adminlte_profile_url()
    {
        return 'profile/username';
    }
}
