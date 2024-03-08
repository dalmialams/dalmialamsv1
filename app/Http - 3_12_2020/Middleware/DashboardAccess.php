<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LandDetailsManagement\RegistrationModel;
use Illuminate\Http\Request;

class DashboardAccess {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null) {

        // t(Auth::user(),1);
        if (Auth::check()) {
            $user = Auth::user();
            $user_type = $user->user_type;
            $user_id = $user->id;
            if ($user_type == 'admin' || \App\Models\UtilityModel::ifHasPermission('dashboard_access', $user_id)) {
                //return redirect('unauthorized-access');
            } else {
                return redirect('landing');
            }
        }
        return $next($request);
    }

}
