<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        smilify('Bienvenido! 🔥 ', 'sesion iniciada con exito');
    }


    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + [
            'status' => 0
        ];
    }
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attemptWhen(
            $this->credentials($request),
            fn ($user) => ! $user->status,
            $request->filled('remember')
        );
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->getLastAttempted();

        throw ValidationException::withMessages([
            $this->username() => [
                $user && $this->guard()->getProvider()->validateCredentials($user, $this->credentials($request))
                    ? 'Usuario no activado contactar con administrador'
                    : trans('auth.failed')
            ]
        ]);
    }
}
