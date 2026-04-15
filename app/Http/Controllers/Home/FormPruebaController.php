<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormPruebaController extends Controller
{
    public function index(Request $request)
    {
        $langCode = $request->input('mltlngg_change_display_lang', 'es_PE');

        // Asegúrate de que existan los archivos lang/es_PE.php, etc.
        $lang = include resource_path("lang/$langCode.php");

        return view('Home.FormPrueba.form_prueba', compact('lang'));
    }
}
