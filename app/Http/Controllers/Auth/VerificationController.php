<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function reenviarCodigo(Request $request)
    {
        $request->validate([
            'correo' => 'required|correo'
        ]);

        $user = Usuario::where('correo', $request->input('correo'))->first();

        if (!$user) {
            return back()->with('error', 'Usuario no encontrado');
        }

        
        $codigo = rand(100000, 999999);

        
        $user->verification_code = $codigo;
        $user->save();

        
        Mail::raw("Tu código de verificación es: $codigo", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('Código de verificación');
        });

        return back()->with('success', 'El código fue reenviado correctamente');
    }
}
