<?php

// Bloque 1: los formularios Blade usan routes/web.php y sesiones con CSRF.
// Se retiran las rutas de prueba y autenticación con tokens para evitar dos flujos.
// Las futuras rutas de API se definirán cuando se implemente el bloque que las necesite.
Route::apiResource('memberships', App\Http\Controllers\MembershipController::class);