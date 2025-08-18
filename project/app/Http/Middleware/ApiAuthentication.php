<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use DB;

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

        $user = DB::select('SELECT * FROM "T_USER" WHERE client_id = \''.$clientId.'\' AND client_secret = \''.$clientSecret.'\'');

        if(!empty($user)){
            $request->merge(['created_id' => $user[0]->id]);
            return $next($request);
        }else{
            return response()->json([
                "status" => false,
                "message" => "Invalid client id or client secret"
            ], 401);
        }
    }
}


