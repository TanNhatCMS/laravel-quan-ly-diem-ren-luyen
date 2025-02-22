<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Theme;
use App\Http\Middleware\ValidateSignature;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware toàn cục (Global Middleware)
        $middleware->use([
            CheckForMaintenanceMode::class,
            ConvertEmptyStringsToNull::class,
        ]);

        // Middleware nhóm 'web'
        $middleware->group('web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            Theme::class,
        ]);

        // Middleware nhóm 'api'
        $middleware->group('api', [
            ThrottleRequests::class . ':60,1',
        ]);

        // Middleware alias (tên ngắn để dùng trong routes)
        $middleware->alias([
            'auth'       => Authenticate::class,
            'auth.basic' => AuthenticateWithBasicAuth::class,
            'guest'      => RedirectIfAuthenticated::class,
            'throttle'   => ThrottleRequests::class,
            'verified'   => EnsureEmailIsVerified::class,
            'signed'     => ValidateSignature::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '*',
            'host' => '*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
//        $exceptions->render(function (AuthenticationException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'message' => $e->getMessage(),
//                ], 401);
//            }
//        });
    })->create();
