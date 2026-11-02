<?php

use App\Http\Controllers\Api\SolicitudPedidoController;
use Illuminate\Support\Facades\Route;

Route::get('/solicitudes-pedido', [SolicitudPedidoController::class, 'index']);
Route::post('/solicitudes-pedido', [SolicitudPedidoController::class, 'store']);
Route::get('/solicitudes-pedido/{id}', [SolicitudPedidoController::class, 'show'])->whereNumber('id');
Route::match(['put', 'patch'], '/solicitudes-pedido/{id}', [SolicitudPedidoController::class, 'update'])->whereNumber('id');
Route::delete('/solicitudes-pedido/{id}', [SolicitudPedidoController::class, 'destroy'])->whereNumber('id');