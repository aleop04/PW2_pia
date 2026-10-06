<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/* RUTAS PUBLICAS */

Route::get('/prueba', function () {
    return response()->json([
        'message' => 'API funcionando correctamente',
    ]);
});

Route::post(
    '/register/student',
    [AuthController::class, 'registerStudent']
);

Route::post(
    '/login',
    [AuthController::class, 'login']
);


/* RUTAS PROTEGIDAS */

Route::middleware('auth:sanctum')->group(function () {

    Route::get(
        '/user',
        [AuthController::class, 'user']
    );

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );

});