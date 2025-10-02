<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Todas as rotas aqui usam o prefixo /api por padrão.
| Ex.: GET /api/ping
*/

Route::get('/ping', function () {
    return response()->json([
        'ok'      => true,
        'php'     => PHP_VERSION,
        'laravel' => app()->version(),
        'time'    => now()->toIso8601String(),
    ]);
});

/**
 * Exemplo protegido com Sanctum (opcional):
 * Para funcionar, habilite Sanctum e o middleware 'auth:sanctum'.
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Exemplo de versão (opcional):
 */
// Route::prefix('v1')->group(function () {
//     Route::get('health', fn () => ['status' => 'ok']);
//     // Route::apiResource('products', App\Http\Controllers\Api\ProductController::class);
// });
