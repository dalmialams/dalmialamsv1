<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LandDetailsManagement\RegistrationModel;
use Illuminate\Http\Request;

class CheckPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null) {

//        echo $permission;
//        t(Auth::user(), 1);
        if (Auth::check() && $permission) {
            $user = Auth::user();
            $user_type = $user->user_type;
            if ($user_type !== 'admin') {
                $user_obj = new \App\Models\User\UserModel();
                $has_permission = $user_obj->ifHasPermission($permission, $user->id);
                if (!$has_permission) {
                    return redirect('unauthorized-access');
                }
            }
        }
        return $next($request);
    }

}
