<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    use AuthenticatesUsers;

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.autenticar');
    }

    public function verificarCodigo(Request $request)
    {
        $this->validate($request, [
            'two_factor_key' => 'required',
        ]);

        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            $usuario = Auth::user();
            $google2fa = new Google2FA();

            if ($google2fa->verifyKey($usuario->two_factor_key, $request->two_factor_key)) {
                return redirect()->route('proyectos.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Código incorrecto');
            }
        } else {
            return redirect()->route('login');
        }
    }

    protected function cancelTwoFactorResponse(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
}
