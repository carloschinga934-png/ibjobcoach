<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class EbookController extends Controller
{
    public function info_ebook()
    {
        return view('info_ebook');
    }


    public function ver_ebook(Request $request)
    {
        $fechaFiltro = $request->input('fecha'); // formato YYYY-MM-DD
        $precioMin = $request->input('precio_min');
        $precioMax = $request->input('precio_max');

        $ruta = public_path('img/ebook');
        $archivosPDF = File::glob($ruta . '/*.pdf');

        $preciosEbooks = [
            'Prueba 1.pdf' => 5.00,
            'Prueba 2.pdf' => 10.00,
            // etc...
        ];
        $precioDefault = 5.00;

        $ebooks = collect($archivosPDF)->map(function ($archivo, $index) use ($preciosEbooks, $precioDefault) {
            $nombre = basename($archivo);
            return [
                'id' => $index + 1,
                'titulo' => $nombre,
                'ruta' => 'img/ebook/' . $nombre,
                'fecha' => date('Y-m-d', filemtime($archivo)),
                'precio' => $preciosEbooks[$nombre] ?? $precioDefault,
            ];
        });

        if ($fechaFiltro) {
            $ebooks = $ebooks->filter(fn($ebook) => $ebook['fecha'] >= $fechaFiltro);
        }
        if ($precioMin !== null) {
            $ebooks = $ebooks->where('precio', '>=', (float)$precioMin);
        }
        if ($precioMax !== null) {
            $ebooks = $ebooks->where('precio', '<=', (float)$precioMax);
        }

        $ebooks = $ebooks->sortByDesc('fecha')->values();

        return view('ver_ebook', [
            'ebooks' => $ebooks,
            'fechaFiltro' => $fechaFiltro,
            'precioMin' => $precioMin,
            'precioMax' => $precioMax,
        ]);
    }

   

    public function verificar_voucher_ebook()
    {
        return view('verificar_voucher_ebook');
    }

    public function show(Request $request)
    {



    }

    public function stripeCheckout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $ebooks = $request->input('ebooks', []);
        // Aquí deberías buscar los ebooks y sus precios
        $line_items = [];
        foreach ($ebooks as $ebook) {
            // Busca el ebook real desde tu BD según el id, asigna precio real
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $ebook['titulo'],
                    ],
                    'unit_amount' => 500, // Ejemplo: $5.00 USD en centavos
                ],
                'quantity' => 1,
            ];
        }
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('ebook').'?success=1',
            'cancel_url' => route('ebook').'?cancel=1',
        ]);
        return response()->json(['url' => $session->url]);
    }
}
