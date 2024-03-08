<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthDashboardSateDistBlockVil {

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
                // $registration_data = $request->get('registration');
                $state_id = $request->get('state_id');
                $district_id = $request->get('district_id');
                $block_id = $request->get('block_id');
                $village_id = $request->get('village');
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
                if ($block_id) {
                  //  echo $block_id;exit;
                    $district_id = \App\Models\Common\BlockModel::where(['id' => $block_id])->value('district_id');
                    $dist_exists = \App\Models\User\AssginedStateDistrictModel::where(['district_id' => $district_id, 'user_id' => $user->id])->get()->toArray();
                    if (empty($dist_exists)) {
                        return redirect('unauthorized-access');
                    }
                }
                if ($village_id) {
                    $district_id = \App\Models\Common\VillageModel::where(['id' => $village_id])->value('district_id');
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
