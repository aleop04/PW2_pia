<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyMembershipController;
use App\Http\Controllers\CompanyReviewController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Postman utiliza cookies de sesión y X-CSRF-TOKEN, igual que los formularios web.
Route::middleware('web')->group(function () {
    Route::get('/session', function (Request $request) {
        $user = $request->user('web');

        return response()->json([
            'csrf_token' => csrf_token(),
            'user' => $user ? ['id' => (string) $user->getKey(), 'email' => $user->email, 'role' => $user->role] : null,
        ])->header('Cache-Control', 'no-store, private');
    });
    Route::get('/memberships', [MembershipController::class, 'index']);

    Route::prefix('admin')->middleware(['auth:web', 'role:admin'])->group(function () {
        Route::get('/students', [AdminController::class, 'students']);
        Route::get('/students/{id}', [AdminController::class, 'student'])->where('id', '[a-f0-9]{24}');
        Route::get('/students/{id}/{document}', [AdminController::class, 'document'])->where('id', '[a-f0-9]{24}')->where('document', 'cv|kardex');
        Route::get('/companies', [AdminController::class, 'companies']);
        Route::get('/companies/{id}', [AdminController::class, 'company'])->where('id', '[a-f0-9]{24}');
        Route::get('/memberships', [MembershipController::class, 'index']);
        Route::post('/memberships', [MembershipController::class, 'store']);
        Route::get('/memberships/{id}', [MembershipController::class, 'show'])->where('id', '[a-f0-9]{24}');
        Route::match(['put', 'patch'], '/memberships/{id}', [MembershipController::class, 'update'])->where('id', '[a-f0-9]{24}');
        Route::delete('/memberships/{id}', [MembershipController::class, 'destroy'])->where('id', '[a-f0-9]{24}');
        Route::get('/payments', [AdminController::class, 'payments']);
        Route::get('/payments/{id}', [AdminController::class, 'payment'])->where('id', '[a-f0-9]{24}');
    });
    Route::prefix('company')->middleware(['auth:web', 'role:company'])->group(function () {
        Route::get('/membership', [CompanyMembershipController::class, 'index']);
        Route::post('/membership/orders', [CompanyMembershipController::class, 'store']);
        Route::patch('/membership/orders/{id}/cancel', [CompanyMembershipController::class, 'cancel'])->where('id', '[a-f0-9]{24}');
    });

    // Compatibilidad con el CRUD anterior: las rutas generales quedan reservadas al administrador.
    Route::middleware(['auth:web', 'role:admin'])->group(function () {
        Route::apiResource('memberships', MembershipController::class)->except('index');
        Route::apiResource('users', UserController::class);
        Route::get('/subscriptions', [AdminController::class, 'payments']);
        Route::get('/subscriptions/{id}', [AdminController::class, 'payment'])->where('id', '[a-f0-9]{24}');
        Route::apiResource('vacancies', VacancyController::class);
        Route::apiResource('applications', ApplicationController::class);
        Route::apiResource('company_reviews', CompanyReviewController::class);
        Route::apiResource('bookmarks', BookmarkController::class)->only(['index', 'store', 'show', 'destroy']);
    });
});
