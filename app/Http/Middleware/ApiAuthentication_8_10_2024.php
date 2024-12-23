<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthentication {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null) {


        $clientId = $request->header('Client-Id');
        $clientSecret = $request->header('Client-Secret');
        if(($clientId === env('API_CLIENT_ID')) && ($clientSecret === env('API_CLIENT_SECRET'))){
            return $next($request);
        }else{
            return response()->json([
                "status" => false,
                "message" => "Invalid client id or client secret"
            ], 401);
        }
    }

}


