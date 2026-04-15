<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Mail\CodigoResetPassword;

class ForgotPasswordController extends Controller
{
    // 1. Mostrar formulario para solicitar el correo
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // 2. Enviar código al correo
    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|exists:usuarios,correo',
        ]);

        $codigo = rand(100000, 999999);

        // Guardar código y expiración en la BD
        $usuario = Usuario::where('correo', $request->correo)->first();
        $usuario->codigo_reset = $codigo;
        $usuario->codigo_expira_en = Carbon::now()->addMinutes(15);
        $usuario->save();

        // Enviar email (puedes personalizar el mensaje)
       
        Mail::to($request->correo)->send(new CodigoResetPassword($codigo));

        // Redirigir a formulario de código
        return redirect()->route('password.code.form')
            ->with('correo', $request->correo)
            ->with('status', 'Código enviado a tu correo');
    }

    // 3. Formulario para ingresar código y nueva contraseña
    public function showCodeForm(Request $request)
    {
        $correo = session('correo', old('correo'));
        return view('auth.passwords.code', compact('correo'));
    }

    // 4. Verificar código y cambiar contraseña
    public function verifyCodeAndReset(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email|exists:usuarios,correo',
            'codigo'   => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $usuario = Usuario::where('correo', $request->correo)
            ->where('codigo_reset', $request->codigo)
            ->where('codigo_expira_en', '>=', Carbon::now())
            ->first();

        if (!$usuario) {
            return back()->withErrors(['codigo' => 'Código incorrecto o expirado'])->withInput();
        }

        $usuario->password = Hash::make($request->password);
        $usuario->codigo_reset = null;
        $usuario->codigo_expira_en = null;
        $usuario->save();

        return redirect()->route('login')->with('status', 'Contraseña cambiada correctamente');
    }
}
