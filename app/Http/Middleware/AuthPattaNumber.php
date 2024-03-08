<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LandDetailsManagement\RegistrationModel;
use Illuminate\Http\Request;

class AuthPattaNumber {

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
        $uniq_patta_no = $request->get('patta_uniq_no');
        if ($uniq_patta_no) {
            $res = \App\Models\LandDetailsManagement\PattaModel::where(['id' => $uniq_patta_no])->get()->toArray();
           // t($res, 1);
             $state_id = isset($res[0]['state_id']) ? $res[0]['state_id'] : '';
            $district_id = isset($res[0]['district_id']) ? $res[0]['district_id'] : '';
            if (empty($res)) {
                return redirect('land-details-entry/patta/add');
            }
            if (Auth::check()) {
                $user_type = Auth::user()->user_type;
                $user_id = Auth::user()->id;
                if ($user_type !== 'admin') {
                    if ($state_id && $district_id) {
                        $assigned_st_dist = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => $state_id, 'district_id' => $district_id, 'user_id' => $user_id])->get()->toArray();
                      //  t($assigned_st_dist,1);
                        if (empty($assigned_st_dist)) {
                            return redirect('unauthorized-access');
                        }
                    } else {
                        return redirect('land-details-entry/patta/add');
                    }
                }
            }

            // return redirect('home');
        }
        return $next($request);
    }

}
