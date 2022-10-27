<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PassportClientsController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PruebaApiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraEstadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraTipoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ItemCategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UnimedController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CompraDetalleController;
use App\Http\Controllers\ItemComentarioController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\VentaEstadoController;
//use App\Http\Controllers\VentaController;

Auth::routes(['verify' => true]);

Route::get('login/{driver}', [LoginController::class,'redirectToProvider'])->name('social_auth');
Route::get('login/{driver}/callback', [LoginController::class,'handleProviderCallback']);



/**
 * Rutas admin
 */
Route::group(['prefix' => 'admin','middleware' => ['role:Admin|Superadmin|Developer','auth']], function () {


    Route::group(['as' => 'admin.'],function (){

        Route::get('/', [HomeAdminController::class,'index'])->name('index');
        Route::get('/home', [HomeAdminController::class,'index'])->name('home');
        Route::get('/dashboard', [HomeAdminController::class,'dashboard'])->name('dashboard');
        Route::get('/calendar', [HomeAdminController::class,'calendar'])->name('calendar');


        Route::get('profile', [ProfileController::class,'index'])->name('profile');
        Route::patch('profile/{user}', [ProfileController::class,'update'])->name('profile.update');
        Route::post('profile/{user}/edit/avatar', [ProfileController::class,'editAvatar'])->name('profile.edit.avatar');

    });


    Route::get('profile/business', [BusinessProfileController::class,'index'])->name('profile.business');
    Route::post('profile/business', [BusinessProfileController::class,'store'])->name('profile.business.store');



    Route::resource('users', UserController::class);
    Route::get('user/{user}/menu', [UserController::class,'menu'])->name('user.menu');;
    Route::patch('user/menu/{user}', [UserController::class,'menuStore'])->name('users.menuStore');

    Route::get('option/create/{option}', [OptionController::class,'create'])->name('option.create');
    Route::get('option/orden', [OptionController::class,'updateOrden'])->name('option.order.store');
    Route::resource('options',OptionController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('permissions', PermissionController::class);


    Route::resource('compraEstados', CompraEstadoController::class);


    Route::resource('clientes', ClienteController::class);


    Route::resource('proveedors', ProveedorController::class);


    Route::resource('compraTipos', CompraTipoController::class);


    Route::get('compras/ingreso/{id}',[CompraController::class,'ingreso'])->name('compra.ingreso');
    Route::post('compras/anular/{compra}', [CompraController::class,'anular'])->name('compras.anular');
    Route::resource('compras', CompraController::class);


    Route::resource('itemCategorias', ItemCategoriaController::class);


    Route::resource('marcas', MarcaController::class);


    Route::resource('unimeds', UnimedController::class);


    Route::resource('items', ItemController::class);


    Route::resource('compraDetalles', CompraDetalleController::class);


    Route::resource('itemComentarios', ItemComentarioController::class);


    Route::resource('tipoPagos', TipoPagoController::class);


    Route::resource('ventaEstados', VentaEstadoController::class);


    Route::get('ventas/comprobante/pdf/{venta}', [VentaController::class,'comprobanteHtml2Pdf'])->name('ventas.comprobante.pdf');
    Route::get('ventas/factura/{venta}', [VentaController::class,'facturaView'])->name('ventas.factura.view');
    Route::get('ventas/cancelar/{venta}', [VentaController::class,'cancelar'])->name('ventas.cancelar');
    Route::post('ventas/anular/{venta}', [VentaController::class,'anular'])->name('ventas.anular');
    Route::resource('ventas', VentaController::class);

    Route::group(['prefix' => 'pedidos','as' => 'pedidos.'],function (){

        Route::get('/', [PedidosController::class,'index'])->name('index');
        Route::get('datos', [PedidosController::class,'datos'])->name('datos');
        Route::get('cambio/estado/{venta}', [PedidosController::class,'cambioEstado'])->name('cambio.estado');
        Route::get('anular/{venta}', [PedidosController::class,'anular'])->name('anular');

    });


    Route::group(['prefix' => 'dev','as' => 'dev.'],function (){

        Route::get('prueba/api',[PruebaApiController::class,'index'])->name('prueba.api');

        Route::get('passport/clients', [PassportClientsController::class,'index'])->name('passport.clients');

        Route::resource('configurations', ConfigurationController::class);

    });



});





/**
 * Rutas web
 */
Route::group(['prefix' => ''], function () {



    Route::get('/', [HomeController::class,'index'])->name('index');
    Route::get('home', [HomeController::class,'index'])->name('home');

    Route::get('about', [HomeController::class,'about'])->name('about');
    Route::get('contact', [HomeController::class,'contact'])->name('contact');
    Route::get('productos/{item}', [HomeController::class,'fichaProducto'])->name('productos.ficha');
    Route::get('productos', [HomeController::class,'tienda'])->name('tienda');
    Route::get('categorias', [HomeController::class,'categorias'])->name('categorias');
    Route::get('marcas', [HomeController::class,'marcas'])->name('marcas');
    Route::get('perfil', [HomeController::class,'perfil'])->name('perfil');



    Route::group(['prefix' => 'carrito','as' => "carrito."], function () {

        Route::get('/', [CartController::class,'index'])->name('index');
        Route::get('data', [CartController::class,'data'])->name('datos');
        Route::post('agregar', [CartController::class,'agregar'])->name('agregar');
        Route::get('quitar/{id}', [CartController::class,'remove'])->name('quitar');
        Route::get('pagar', [CartController::class,'pagar'])->name('pagar');
        Route::post('confirma', [CartController::class,'confirmaPago'])->name('pagar.confirmar');
        Route::get('exito/{venta}', [CartController::class,'exito'])->name('exito');
        Route::get('imprime/factura/{venta}', [CartController::class,'imprimeFactura'])->name('imprime.factura');
    });

    Route::get('cambio/idioma/{lang}', [HomeController::class,'cambioIdioma'])
        ->where([
            'lang' => 'en|es'
        ])
        ->name('cambio.idioma');


});


