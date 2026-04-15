<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //Se obtiene el usuario completo de la base de datos que ha sido logueado
        $usuario = $request->user(); // Es lo mismo que Auth::user()

        if (!$usuario) {
            return redirect()->route('login');
        }

        // Si el usuario tiene algún rol permitido
        if ($usuario->role && in_array($usuario->role->nombre, $roles)) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
