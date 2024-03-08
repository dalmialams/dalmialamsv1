<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        'guest' => \App\Http\Middleware\MenuItem::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            'throttle:60,1',
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
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'authRegNum' => \App\Http\Middleware\AuthRegNumber::class,
        'auth_patta_num' => \App\Http\Middleware\AuthPattaNumber::class,
        'check_if_admin' => \App\Http\Middleware\CheckIfAdmin::class,
        'auth_reg_search' => \App\Http\Middleware\AuthRegSearch::class,
        'auth_patta_search' => \App\Http\Middleware\AuthPattaSearch::class,
        'check_permission' => \App\Http\Middleware\CheckPermission::class,
        'menu_item' => \App\Http\Middleware\MenuItem::class,
        'auth_dashboard_state_dist_block_vil' => \App\Http\Middleware\AuthDashboardSateDistBlockVil::class,
        'dashboard_access' => \App\Http\Middleware\DashboardAccess::class,
    ];

}
