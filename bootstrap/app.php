<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // <<< 1. ASEGÚRATE DE QUE ESTO ESTÉ IMPORTADO

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // >>>>>>>>>>>>>> INICIO DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<
        // 2. Registra tu alias de middleware aquí
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);
        // >>>>>>>>>>>>>> FIN DE CÓDIGO NUEVO <<<<<<<<<<<<<<<<<<

        // (Aquí pueden ir otros middlewares globales, etc.)

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
