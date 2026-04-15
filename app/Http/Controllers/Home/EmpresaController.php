<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmpresaContactoMail;

class EmpresaController extends Controller
{
    public function contacto(Request $request)
    {
        $data = $request->validate([
            'empresa' => 'required|string|max:120',
            'email' => 'required|email|max:100',
            'pais' => 'required|string|max:60',
            'telefono' => 'required|string|max:20',
            'name' => 'required|string|max:120',
            'cargo' => 'required|string|max:120',
        ]);

        $correoDestino = config('mail.contacto_empresa'); // <- Lo toma del .env

        Mail::to($correoDestino)->send(new EmpresaContactoMail($data));

        return back()->with('success', '¡Gracias! Nos pondremos en contacto contigo pronto.');
    }
}
