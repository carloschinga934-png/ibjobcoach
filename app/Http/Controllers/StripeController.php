<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function charge(Request $request)
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        //Obtener token enviado desde el JS (esto es un token que identifica las credenciales del cliente)
        $token = $request->input('stripeToken');
        try {
            // Intentar el cobro
            $charge = \Stripe\Charge::create([
                "amount" => 1500, // en centavos: $15.00
                "currency" => "usd",
                "description" => "Pago en mi tienda...",
                "source" => $token
            ]);

            // Verificar si fue exitoso
            if ($charge->status === 'succeeded') {
                return back()->with('success_message', '✅ ¡Pago realizado con éxito!');
            } else {
                return back()->with('error_message', '❌ El pago no fue procesado.');
            }

        } catch (\Exception $e) {
            // Error al procesar el pago
            return back()->with('error_message', '❌ Error: ' . $e->getMessage());
        }
    }
}
