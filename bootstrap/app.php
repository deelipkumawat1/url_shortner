<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\MemberAuthenticate;
use App\Http\Middleware\Redirect;
use App\Http\Middleware\SuperAdminAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest' => Redirect::class,
            'admin.auth' => AdminAuthenticate::class,
            'sadmin.auth' => SuperAdminAuthenticate::class,
            'member.auth' => MemberAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
