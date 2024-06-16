<?php

use App\Http\Middleware\RedirectToHttps;
use App\Http\Middleware\SessionTimeOut;
use App\Http\Middleware\UserAkses;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'userAkses' => UserAkses::class,
            'sessionCheck' => SessionTimeOut::class,
            'to.secure.link'=>RedirectToHttps::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();