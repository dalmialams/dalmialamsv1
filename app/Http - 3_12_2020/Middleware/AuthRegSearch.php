<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LandDetailsManagement\RegistrationModel;
use Illuminate\Http\Request;

class AuthRegSearch {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null) {

        //t(Auth::user(),1);
        //$uniq_reg_no = $request->get('reg_uniq_no');
        if (Auth::check()) {
            $user = Auth::user();
            $user_type = $user->user_type;
            if ($user_type !== 'admin') {
                $registration_data = $request->get('registration');
                $state_id = isset($registration_data['state_id']) ? $registration_data['state_id'] : '';
                $district_id = isset($registration_data['district_id']) ? $registration_data['district_id'] : '';
                if ($state_id) {
                    $state_exists = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => $state_id, 'user_id' => $user->id])->get()->toArray();                   
                    if (empty($state_exists)) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($district_id) {
                    $dist_exists = \App\Models\User\AssginedStateDistrictModel::where(['district_id' => $district_id, 'user_id' => $user->id])->get()->toArray();
                    if (empty($dist_exists)) {
                        return redirect('unauthorized-access');
                    }
                }
            }
        }
        return $next($request);
    }

}
