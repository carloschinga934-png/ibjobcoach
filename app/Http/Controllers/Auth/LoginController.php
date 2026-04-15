<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = [
            'correo'   => $request->input('correo'),
            'password' => $request->input('password'),
        ];
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['correo' => __('auth.failed')])
                ->onlyInput('correo');
        }

        $request->session()->regenerate();

        /** @var \App\Models\Usuario|Model $user */
        $user = Auth::user();

        // Opcional: tocar "updated_at" como último login
        if ($user instanceof Model) {
            $user->touch();
        }

        // (Opcional pero recomendado) bloquear según estado
        if (in_array($user->status, ['inactivo', 'suspendido'])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()
                ->route('login')
                ->withErrors(['correo' => 'Tu cuenta está '.$user->status.'. Contacta al administrador.']);
        }

        // Redirección por rol
        $role = optional($user->role)->nombre; // admin | empleado | usuario

        $destinos = [
            'admin'    => 'admin.dashboard',
            'empleado' => 'empleado.dashboard',
            'usuario'  => 'usuario.dashboard',
        ];

        // Si el rol no existe o no está mapeado, volver al login
        $ruta = $destinos[$role] ?? 'login';

        // intended() respeta la URL protegida a la que intentó entrar antes del login
        return redirect()->intended(route($ruta));
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
