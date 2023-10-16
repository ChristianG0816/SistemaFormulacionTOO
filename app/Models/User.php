<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Contracts\Google2FA;

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
        'two_factor_key',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'two_factor_key',
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

    //Verifica autenticación de dos pasos
    public function is2FAVerified()
    {
        // Verifica si el usuario ha verificado la autenticación de dos pasos
        $google2fa = app(Google2FA::class);
        return $this->two_factor_key_verified && $google2fa->verifyKey($this->two_factor_key, request('2fa_code'));
    }

    //En caso que le pongamos imagen al usuario se 
    //debe de usar este metodo para recuperarlo de la base

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    //aqui hay que recuperar el rol del usuario
    public function adminlte_desc(){
    // Verifica si el usuario está autenticado
    if (Auth::check()) {
        // Obtiene la instancia del usuario autenticado
        $user = Auth::user();
        
        // Verifica si el usuario tiene al menos un rol
        if ($user->roles->count() > 0) {
            // Recupera el primer rol asignado al usuario (puedes ajustar esto según tus necesidades)
            $role = $user->roles->first();
            // Recupera el nombre del rol
            $roleName = $role->name;
            return "Rol actual: $roleName";
        }
    }
    
    return "Usuario no autenticado o sin roles asignados";
}


    //acceder al perfil del usuario
   /* public function adminlte_profile_url()
    {
        return 'profile/username';
    }*/
}
