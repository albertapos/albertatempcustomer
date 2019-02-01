<?php

namespace pos2020\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \pos2020\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \pos2020\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
//            \pos2020\Http\Middleware\CORS::class,
            \pos2020\Http\Middleware\HttpsProtocol::class,

        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            'jwt-auth' => \pos2020\Http\Middleware\authJWT::class,
            //'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
            //'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \pos2020\Http\Middleware\RedirectIfAuthenticated::class,
        'role' => \Bican\Roles\Middleware\VerifyRole::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'jwt-auth' => \pos2020\Http\Middleware\authJWT::class,
        'cors' => \pos2020\Http\Middleware\CORS::class,
        'StoreDatabaseSelection'  =>  \pos2020\Http\Middleware\StoreDatabaseSelection::class,
        //'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        //'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        
    ];
}
