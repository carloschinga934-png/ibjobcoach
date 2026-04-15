<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\Home\FormPruebaController;
use App\Http\Controllers\Home\TraduccionController;
use App\Http\Controllers\Home\EbookController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Home\PriceController;
use App\Http\Controllers\Home\PosicionController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Home\PaypalDirectController;
use App\Http\Controllers\Home\EmpresaController;
use App\Http\Controllers\Auth\ForoController;
use App\Http\Controllers\Auth\ContenidoController;
use App\Http\Controllers\Auth\AlumniController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\TicketsController;


// ----------- RUTAS GENERALES -----------

Route::get('/', fn() => view('Home.home'))->name('home');
Route::match(['get', 'post'], '/form-prueba', [FormPruebaController::class, 'index']);

// Cambiar idioma
Route::post('/cambiar-idioma', [TraduccionController::class, 'cambiar'])->name('cambiar.idioma');

// Cambio de idioma alternativo
Route::post('/change-language', function (Request $request) {
    $lang = $request->input('mltlngg_change_display_lang');
    Session::put('mltlngg_change_display_lang', $lang);
    return back();
});

// ----------- EBOOKS Y PAGOS -----------

Route::controller(EbookController::class)->group(function () {
    Route::get('/ebook', 'show')->name('ebook');
    Route::get('/pago-ebook', 'show')->name('pago.ebook'); // Ojo: si tienes una vista diferente, cambia el método
    Route::get('/info_ebook', 'info_ebook')->name('info_ebook');
    Route::get('/ver_ebook', 'ver_ebook')->name('ver_ebook');
    Route::get('/pago_ebook', 'pago_ebook')->name('pago_ebook');
    Route::get('/verificar_voucher_ebook', 'verificar_voucher_ebook')->name('verificar_voucher_ebook');
    // routes/web.php
    Route::post('/stripe/checkout', [EbookController::class, 'stripeCheckout'])
    ->name('stripe.checkout');

});
// ----------- Rutas de usuarios -----------

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('users.index');  // Para ver todos los usuarios

// Ruta para ver un usuario individual
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('users.show');


// ----------- PRECIOS Y PAGOS -----------

Route::controller(PriceController::class)->group(function () {
    Route::get('/precios', 'index')->name('precios.index');
    Route::post('/precios/contact', 'contact')->name('precios.contact');
    Route::post('/precios/pago', 'checkout')->name('precios.checkout');
});

// ----------- CONTACTO EMPRESA -----------
Route::post('/contacto-empresa', [EmpresaController::class, 'contacto'])->name('empresa.contacto');


// ----------- AUTENTICACIÓN Y DASHBOARD -----------

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.attempt');
    Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('register', [RegisterController::class, 'register'])->name('register.attempt');
    // Recuperar contraseña
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetCodeEmail'])->name('password.email');
    Route::get('password/code', [ForgotPasswordController::class, 'showCodeForm'])->name('password.code.form');
    Route::post('password/reset', [ForgotPasswordController::class, 'verifyCodeAndReset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    
});

// ----------- API -----------
// API para posiciones
Route::get('/api/posiciones', [PosicionController::class, 'consultarPosiciones']);
// API: Validar cupon (DEMO, cambia por consulta a DB real en producción)
Route::get('/api/validar-cupon', function(Request $request) {
    $validos = ['DESCUENTO10', 'PROMO20'];
    return response()->json([
        'valido' => in_array(strtoupper($request->codigo), $validos)
    ]);
});

// ----------- VISTAS LEGALES -----------

Route::view('/terminos', 'terminos')->name('terminos');
Route::view('/privacidad', 'privacidad')->name('privacidad');

// ----------- FUNCIONES ADICIONALES -----------

// Validar credenciales del modal eBook
Route::post('/validar-credenciales', [LoginController::class, 'validarCredencialesEbook'])->name('validar.credenciales');

// Consulta legal (demo)
Route::post('/consulta-legal', function (Request $request) {
    // Procesa la consulta aquí (guardar DB, enviar correo, etc)
    return back()->with('success', 'Tu consulta fue enviada con éxito.');
})->name('consulta.legal');


Route::view('/ver_detalle_ebook', 'ver_detalle_ebook')->name('ver_detalle_ebook');
//================================================================================================================================================
//CONTENIDO DEL DASHBOARD DEL CODIGO DE PHP NATIVO
// Rutas dummy para las tarjetas del dashboard
// No funcionan por ahora
//Route::get('/entrevista', fn() => view('auth.dashboard.placeholder', ['title' => 'Técnicas de Entrevista']))->name('entrevista.index');
//Route::get('/outplacement', fn() => view('auth.dashboard.placeholder', ['title' => 'Sesiones Outplacement']))->name('outplacement.index');
//Route::get('/biblioteca', fn() => view('auth.dashboard.placeholder', ['title' => 'Biblioteca']))->name('biblioteca.index');
//Route::get('/templates', fn() => view('auth.dashboard.placeholder', ['title' => 'Templates']))->name('templates.index');
//Route::get('/cv', fn() => view('auth.dashboard.placeholder', ['title' => 'CV']))->name('cv.index');
//Route::get('/match-mercado', fn() => view('auth.dashboard.placeholder', ['title' => 'Match de Mercado']))->name('match.index');
//Route::get('/propuesta-valor', fn() => view('auth.dashboard.placeholder', ['title' => 'Propuesta de Valor']))->name('propuesta.index');
//Route::get('/contenido-linkedin', fn() => view('auth.dashboard.placeholder', ['title' => 'Contenido de LinkedIn']))->name('linkedin.index');
//Route::get('/casa-procesos', fn() => view('auth.dashboard.placeholder', ['title' => 'Casa de Procesos']))->name('casa.index');
//Route::get('/conocimiento-personal', fn() => view('auth.dashboard.placeholder', ['title' => 'Conocimiento Personal']))->name('personal.index');

//================================================================================================================================================

//STRIPE
Route::view('/stripe', 'stripe')->name('stripe');

Route::post('/stripe/charge', [StripeController::class, "charge"])->name("stripe.charge");


// Rutas de roles y usuarios
Route::prefix('admin')
    ->middleware(['auth', EnsureUserHasRole::class . ':admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
        Route::get('/usuarios/{id}/editar', [AdminController::class, 'editUsuario'])->name('usuarios.editar');
        Route::post('/usuarios/{id}/actualizar', [AdminController::class, 'updateUsuario'])->name('usuarios.actualizar');
        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
        Route::get('/articulos', [AdminController::class, 'articulos'])->name('articulos');
        Route::get('/reportes', [AdminController::class, 'reportes'])->name('reportes');
        Route::delete('/usuarios/{id}/eliminar', [AdminController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
    });

// ----------- RUTA PARA EL EMPLEADO DASHBOARD -----------

Route::middleware('auth', EnsureUserHasRole::class . ':empleado')  // Asegúrate de que el usuario tenga el rol 'empleado'
    ->get('/empleado/dashboard', [EmpleadoController::class, 'dashboard'])->name('empleado.dashboard');  // Ruta para el dashboard del empleado
//- NOTAS DE USUARIOS -----------
Route::prefix('usuarios/{usuarioId}')->middleware('auth')->group(function () {
    Route::get('/notas', [NotasController::class, 'index'])->name('notas.index');
    Route::get('/notas/crear', [NotasController::class, 'create'])->name('notas.create');
    Route::post('/notas', [NotasController::class, 'store'])->name('notas.store');
    Route::get('/notas/{notaId}', [NotasController::class, 'show'])->name('notas.show');
    Route::get('/notas/{notaId}/editar', [NotasController::class, 'edit'])->name('notas.edit');
    Route::put('/notas/{notaId}', [NotasController::class, 'update'])->name('notas.update');
    Route::delete('/notas/{notaId}', [NotasController::class, 'destroy'])->name('notas.destroy');
});
// ----------- TICKETS -----------
Route::middleware('auth')->group(function () {
    // Dashboard y gestión general de tickets
    Route::get('/tickets/dashboard', [TicketsController::class, 'dashboard'])->name('tickets.dashboard');
    Route::get('/tickets/validacion', [TicketsController::class, 'dashboardValidacion'])->name('tickets.validacion');
    Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets.general');
    // ✅ KANBAN MOVIDO AQUÍ - SIN usuarioId
    Route::get('/tickets/kanban', [TicketsController::class, 'kanban'])->name('tickets.kanban');

    // Acciones globales de tickets (sin usuarioId) - SOLO estas
    Route::post('/tickets/{ticketId}/asignar', [TicketsController::class, 'asignar'])->name('tickets.asignar');
    Route::post('/tickets/{ticketId}/validar', [TicketsController::class, 'validar'])->name('tickets.validar');
    Route::post('/tickets/{ticketId}/rechazar-validacion', [TicketsController::class, 'rechazarValidacion'])->name('tickets.rechazar');

    // Tickets específicos por usuario
    Route::prefix('usuarios/{usuarioId}')->group(function () {
        Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/crear', [TicketsController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketsController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticketId}', [TicketsController::class, 'show'])->name('tickets.show');
        Route::get('/tickets/{ticketId}/editar', [TicketsController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{ticketId}', [TicketsController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticketId}', [TicketsController::class, 'destroy'])->name('tickets.destroy');
        
        // ✅ CORREGIDO: Solo /historial, sin duplicar la estructura
        Route::get('/historial', [TicketsController::class, 'historial'])->name('tickets.historial');
        Route::get('/reportes', [TicketsController::class, 'reportes'])->name('tickets.reportes'); 
        // Acciones específicas por usuario
        Route::post('/tickets/{ticketId}/resolver', [TicketsController::class, 'resolver'])->name('tickets.resolver.user');
        Route::post('/tickets/{ticketId}/validar', [TicketsController::class, 'validar'])->name('tickets.validar.user');
        Route::post('/tickets/{ticketId}/rechazar-validacion', [TicketsController::class, 'rechazarValidacion'])->name('tickets.rechazar.user');
    });
});