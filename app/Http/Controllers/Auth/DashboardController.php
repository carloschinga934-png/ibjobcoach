<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Articulo;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarjetas de la sección ACTUAL
        $cardsActuales = [
            [
                'title' => 'Técnicas de Entrevista',
                'icon' => 'all_inbox',
                'color' => 'ib-red',
                'custom_class' => 'card-entrevista',
                'url' => route('entrevista.index')
            ],
            [
                'title' => 'Sesiones Outplacement',
                'icon' => 'book',
                'color' => 'ib-dark',
                'custom_class' => 'card-outplacement',
                'url' => route('outplacement.index')
            ],
            [
                'title' => 'Biblioteca',
                'icon' => 'books',
                'color' => 'ib-red',
                'custom_class' => 'card-biblioteca',
                'url' => route('biblioteca.index')
            ],
            [
                'title' => 'Templates',
                'icon' => 'account_balance_wallet',
                'color' => 'ib-dark',
                'custom_class' => 'card-templates',
                'url' => route('templates.index')
            ],
            [
                'title' => 'CV',
                'icon' => 'account_box',
                'color' => 'ib-dark',
                'custom_class' => 'card-cv',
                'url' => route('cv.index')
            ],
            [
                'title' => 'Match de Mercado',
                'icon' => 'card_membership',
                'color' => 'ib-red',
                'custom_class' => 'card-match',
                'url' => route('match.index')
            ],
            [
                'title' => 'Propuesta de Valor',
                'icon' => 'storage',
                'color' => 'ib-dark',
                'custom_class' => 'card-valor',
                'url' => route('propuesta.index')
            ],
            [
                'title' => 'Contenido de LinkedIn',
                'icon' => 'local_atm',
                'color' => 'ib-red',
                'custom_class' => 'card-linkedin',
                'url' => route('linkedin.index')
            ],
            [
                'title' => 'Casa de Procesos',
                'icon' => 'store_mall_directory',
                'color' => 'ib-red',
                'custom_class' => 'card-casa',
                'url' => route('casa.index')
            ],
            [
                'title' => 'Conocimiento Personal',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-personal',
                'url' => route('personal.index')
            ],
        ];

        // Tarjetas de la sección ANTIGUOS (puedes agregar más)
        $cardsAntiguos = [
            [
                'title' => 'Biblioteca',
                'icon' => 'all_inbox',
                'color' => 'ib-red',
                'custom_class' => 'card-biblioteca',
                'url' => '#'
            ],
            [
                'title' => 'Empresa por industria',
                'icon' => 'book',
                'color' => 'ib-dark',
                'custom_class' => 'card-industria',
                'url' => '#'
            ],
            [
                'title' => 'Contenidos de LinkedIn',
                'icon' => 'alarm_on',
                'color' => 'ib-red',
                'custom_class' => 'card-linkedin',
                'url' => '#'
            ],
            [
                'title' => 'CV',
                'icon' => 'work_outline',
                'color' => 'ib-dark',
                'custom_class' => 'card-cv',
                'url' => '#'
            ],
            [
                'title' => 'Match de mercado',
                'icon' => 'touch_app',
                'color' => 'ib-red',
                'custom_class' => 'card-match',
                'url' => '#'
            ],
            [
                'title' => 'Propuesta de valor',
                'icon' => 'request_quote',
                'color' => 'ib-dark',
                'custom_class' => 'card-valor',
                'url' => '#'
            ],
            [
                'title' => 'Técnicas de entrevista',
                'icon' => 'accessibility',
                'color' => 'ib-dark',
                'custom_class' => 'card-entrevista',
                'url' => '#'
            ],
            [
                'title' => 'Template',
                'icon' => 'books',
                'color' => 'ib-red',
                'custom_class' => 'card-templates',
                'url' => '#'
            ],
            [
                'title' => 'Video de programas',
                'icon' => 'account_balance_wallet',
                'color' => 'ib-dark',
                'custom_class' => 'card-video',
                'url' => '#'
            ],
            [
                'title' => 'Cursos online',
                'icon' => 'account_box',
                'color' => 'ib-dark',
                'custom_class' => 'card-curso',
                'url' => '#'
            ],
            [
                'title' => 'Películas y libros',
                'icon' => 'card_membership',
                'color' => 'ib-red',
                'custom_class' => 'card-peliculas',
                'url' => '#'
            ],
            [
                'title' => 'Job boards',
                'icon' => 'storage',
                'color' => 'ib-dark',
                'custom_class' => 'card-job',
                'url' => '#'
            ],
            [
                'title' => 'Prospección de redes',
                'icon' => 'local_atm',
                'color' => 'ib-red',
                'custom_class' => 'card-redes',
                'url' => '#'
            ],
            [
                'title' => 'Conocimiento personal',
                'icon' => 'store_mall_directory',
                'color' => 'ib-dark',
                'custom_class' => 'card-personal',
                'url' => '#'
            ],
            [
                'title' => 'Lista de coworkings',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-coworking',
                'url' => '#'
            ],
            [
                'title' => 'Emprendimiento',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-emprendimiento',
                'url' => '#'
            ],
            [
                'title' => 'Primer Trabajo',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-primertrabajo',
                'url' => '#'
            ],
            [
                'title' => 'Tendencias laborales',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-tendencias',
                'url' => '#'
            ],
            [
                'title' => 'Joven emprendedor',
                'icon' => 'streetview',
                'color' => 'ib-dark',
                'custom_class' => 'card-joven',
                'url' => '#'
            ],
        ];

        return view('auth.admin.dashboard', compact('cardsActuales', 'cardsAntiguos'));
    }
    // Importa tu modelo Articulo arriba

    public function tablaArticulos()
    {
        // Obtiene todos los artículos y los pagina de 15 en 15
        $articulos = Articulo::orderBy('idarticulo')->paginate(9);
        return view('auth.admin.tables.tecnicas', compact('articulos'));
    }

}
