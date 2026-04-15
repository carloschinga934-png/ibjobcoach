<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use PayPalCheckoutSdk\Orders\OrdersCreateRequest; // Descomenta si usas el SDK oficial

class PaypalDirectController extends Controller
{
    public function form()
    {
        return view('Home.Paypal.direct');
    }

    public function pay(Request $request)
    {
        $data = $request->validate([
            'concepto' => 'required|string|max:80',
            'importe'   => 'required|numeric|min:1'
        ]);

        // ==============================
        //      PAGO REAL CON PAYPAL
        // ==============================

        // --- Configura tus credenciales ---
        // $clientId = config('services.paypal.client_id');
        // $clientSecret = config('services.paypal.secret');

        // --- SDK PayPal (ejemplo con HTTP client, puedes usar GuzzleHttp o el SDK oficial de PayPal) ---

        /*
        // Descomenta y ajusta cuando actives PayPal
        $environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment($clientId, $clientSecret);
        $client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);

        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');
        $orderRequest->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($data['importe'], 2, '.', '')
                ],
                "description" => $data['concepto']
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success')
            ]
        ];

        try {
            $response = $client->execute($orderRequest);
            if ($response->statusCode == 201) {
                // Redireccionar a PayPal para aprobar el pago
                foreach ($response->result->links as $link) {
                    if ($link->rel === 'approve') {
                        return redirect($link->href);
                    }
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['pago' => 'Error procesando el pago: ' . $e->getMessage()]);
        }
        */

        // =================================
        //    Puedes comentar esto si usas PayPal real
        // =================================
        return back()->with('success', '¡Se realizó el pago de prueba! (Simulado, aún sin integración real)');
    }
}
