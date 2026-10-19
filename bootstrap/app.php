<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureRole;
use MongoDB\Driver\Exception\Exception as MongoDBException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['role' => EnsureRole::class]);
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn (Request $request) => route(
            match ($request->user('web')?->role) {
                'student' => 'student.home',
                'company' => 'company.home',
                default => 'home',
            }
        ));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (MongoDBException $exception, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No fue posible conectar con la base de datos.'], 503);
            }

            return response()->view('errors.503', [], 503);
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
