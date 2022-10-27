<?php

use App\Http\Controllers\API\OptionAPIController;
use App\Http\Controllers\API\PermissionAPIController;
use App\Http\Controllers\API\RoleAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\VentaDetalleAPIController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CompraEstadoAPIController;
use App\Http\Controllers\API\ClienteAPIController;
use App\Http\Controllers\API\ProveedorAPIController;
use App\Http\Controllers\API\CompraTipoAPIController;
use App\Http\Controllers\API\CompraAPIController;
use App\Http\Controllers\API\ItemCategoriaAPIController;
use App\Http\Controllers\API\MarcaAPIController;
use App\Http\Controllers\API\UnimedAPIController;
use App\Http\Controllers\API\ItemAPIController;
use App\Http\Controllers\API\CompraDetalleAPIController;
use App\Http\Controllers\API\ItemComentarioAPIController;
use App\Http\Controllers\API\TipoPagoAPIController;
use App\Http\Controllers\API\VentaEstadoAPIController;
use App\Http\Controllers\API\VentaAPIController;

Route::group(['as'=>'api.'], function () {

    Route::resource('options', OptionAPIController::class);



    Route::group(['middleware' => 'auth:api'], function () {

        Route::resource('permissions', PermissionAPIController::class);

        Route::resource('roles', RoleAPIController::class);

        Route::resource('users', UserAPIController::class);
        Route::get('user/add/shortcut/{user}', [UserAPIController::class,'addShortcut'])->name('users.add_shortcut');
        Route::get('user/remove/shortcut/{user}', [UserAPIController::class,'removeShortcut'])->name('users.remove_shortcut');



        Route::resource('compra_estados', CompraEstadoAPIController::class);


        Route::resource('clientes', ClienteAPIController::class);


        Route::resource('proveedores', ProveedorAPIController::class);


        Route::resource('compra_tipos', CompraTipoAPIController::class);


        Route::resource('compras', CompraAPIController::class);


        Route::resource('item_categorias', ItemCategoriaAPIController::class);


        Route::resource('marcas', MarcaAPIController::class);


        Route::resource('unimeds', UnimedAPIController::class);


        Route::resource('items', ItemAPIController::class);


        Route::resource('compra_detalles', CompraDetalleAPIController::class);


        Route::resource('item_comentarios', ItemComentarioAPIController::class);


        Route::resource('tipo_pagos', TipoPagoAPIController::class);


        Route::resource('venta_estados', VentaEstadoAPIController::class);


        Route::resource('ventas', VentaAPIController::class);

        Route::resource('venta_detalles', VentaDetalleAPIController::class);

    });


});

