<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TraduccionController extends Controller
{
    public function cambiar(Request $request)
    {
        $lang = $request->input('mltlngg_change_display_lang', 'es_PE');

        $idiomasDisponibles = ['es_CL', 'es_PE', 'es_SP', 'es_PA', 'es_UR', 'es_AR', 'es_BL', 'es_MX', 'es_CO'];

        session(['lang' => in_array($lang, $idiomasDisponibles) ? $lang : 'es_PE']);

        return back();
    }
}
