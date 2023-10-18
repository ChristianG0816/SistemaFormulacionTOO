<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\User;

class PerfilController extends Controller
{
    use AuthenticatesUsers;

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        $factorEnabled=$user->two_factor_enabled;
        $qrCode = QrCode::size(200)->generate($google2fa->getQRCodeUrl(config('app.name'), $user->email, $user->two_factor_key));

        return view('auth.perfil', compact('qrCode','factorEnabled','user'));
    }
    public function updateInfo(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $input = $request->all();
        $user = User::find($id);
        
        $user->update($input);
        return redirect()->route('perfil')->witch('user', $user)->with('success', 'Has actualizado la información general de tu perfil');

    }
    public function updatePass(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'old-password' => 'required',
            'password'=>'same:confirm-password',
        ]);

        $input = $request->all();
        
        if (!Hash::check($input['old-password'], $user->password)) {
            return redirect()->route('perfil')->with('error', 'La contraseña actual ingresada es incorrecta');
        }

        $user->password = Hash::make($input['password']);
        $user->save();
        return redirect()->route('perfil')->witch('user', $user)->with('success', 'Contraseña actualizada');
    }

    public function enableFA(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        $user->two_factor_enabled = true;
        $user->two_factor_key = $google2fa->generateSecretKey();
        $user->save();

        return redirect()->route('perfil')->with('success', 'Has habilitado la autenticación de dos pasos');
    }

    public function disableFA(Request $request)
    {
        $user = Auth::user();
        
        $user->two_factor_enabled = false;
        $user->two_factor_key = null;
        $user->save();

        return redirect()->route('perfil')->with('error', 'Has deshabilitado la autenticación de dos pasos');
    }
    
}
