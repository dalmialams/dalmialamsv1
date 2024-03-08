<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use App\Models\User\UserLoginModel;
use Validator;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;

class LoginController extends Controller {

    public function __construct() {
        parent:: __construct();
    }

    public function authUserByCred(Request $request) {

        $posted_data = $request->all();
        $user_name = isset($posted_data['user_name']) ? $posted_data['user_name'] : '';
        $password = isset($posted_data['password']) ? $posted_data['password'] : '';
        $user_obj = UserModel::where(['user_name' => $user_name])->get()->toArray();
	//t($user_obj);exit;
        if ($user_obj) {
            //  t($user_obj);
            $user_id = isset($user_obj[0]['id']) ? $user_obj[0]['id'] : '';
            $user_type = isset($user_obj[0]['user_type']) ? $user_obj[0]['user_type'] : '';
            $current_date = date('Y-m-d');
            $current_date = new \DateTime($current_date);
            $start_date = isset($user_obj[0]['start_date']) ? $user_obj[0]['start_date'] : '';
            $start_date = new \DateTime($start_date);
            $end_date = isset($user_obj[0]['end_date']) ? $user_obj[0]['end_date'] : '';
            $end_date = new \DateTime($end_date);
            $is_date_within_range = \App\Models\UtilityModel::isDateBetweenDates($current_date, $start_date, $end_date);
            $password_check_status = false;

            $user_pass = trim($user_obj[0]['password']);
            if (Hash::check($password, $user_pass)) {
                $password_check_status = true;
            } else {
                $password_check_status = false;
            }
            if ($user_id && $password_check_status) {
                if ($user_type == 'admin' || $is_date_within_range) {
                    Auth::loginUsingId($user_id);
                    //Insert The Ip from where the user login in
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $array['user_id'] = $user_id;
                    $array['login_ip'] = $ip;
                    $array['login_type'] = 'Login';
                    $array['created_at'] = Carbon::now();
                    $array['updated_at'] = Carbon::now();
                    UserLoginModel::insertGetId($array);
                    //if($user_obj[0]['password_update_time']!='')
					if(1==2)
		{
			$todate = date('Y-m-d');
			$last_passupdate_time = date('Y-m-d',strtotime($user_obj[0]['password_update_time']));
			$date1=date_create($todate);
			$date2=date_create($last_passupdate_time);
			$diff_date = date_diff($date1,$date2);
			$diff_days = $diff_date->format('%a');
			if($diff_days > 45)
			{
				echo 5;
			}
			else
			{
			echo 1;
			}
		}
		else
		{
			echo 1;
		}
                } else {
                    echo 2; // user period expired
                }
	
            } else {
                echo 0; //invalid 
            }
        }
    }

    public function checkValidUser(Request $request) {
        $posted_data = $request->all();
        //$email = isset($posted_data['email']) ? trim($posted_data['email']) : '';
        $user_name = isset($posted_data['user_name']) ? trim($posted_data['user_name']) : '';
        if ($user_name) {
            $res = UserModel::where(['user_name' => "{$user_name}", 'fl_archive' => 'N'])->get()->toArray();
            if (empty($res)) {
                echo "false";
                exit;
            } else {
                echo "true";
                exit;
            }
        } else {
            echo "false";
            exit;
        }
    }

    public function logout() {
        //Insert The Ip from where the user login in
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($this->data['current_user_id'])) {
            $array['user_id'] = $this->data['current_user_id'];
            $array['login_ip'] = $ip;
            $array['login_type'] = 'Logout';
            $array['created_at'] = Carbon::now();
            $array['updated_at'] = Carbon::now();
            UserLoginModel::insertGetId($array);
        }
        Auth::logout();
        return redirect('/');
    }
    

}
