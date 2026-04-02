<?php

declare(strict_types=1);

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                $previous = $e->getPrevious();

                if ($previous instanceof ModelNotFoundException) {
                    $model = class_basename($previous->getModel());

                    return response()->json([
                        'success' => false,
                        'message' => "{$model} not found",
                    ], 404);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }
        });
    })->create();