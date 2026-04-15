<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Depuración: muestra la ruta cuando se requiere autenticación
        dd('Middleware Authenticate: usuario no autenticado, redirigiendo a login.');

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
