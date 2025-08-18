<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use App\Models\User\UserLoginModel;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;

class LoginController extends Controller {

    public function __construct() {
        //parent:: __construct();
    }

    public function authUserByCred(Request $request) {

        $posted_data = $request->all();
        $user_name = isset($posted_data['user_name']) ? $posted_data['user_name'] : '';
        $password = isset($posted_data['password']) ? $posted_data['password'] : '';
        $user_obj = UserModel::where(['user_name' => $user_name])->get()->toArray();
        if ($user_obj) {
            $user_id = isset($user_obj[0]['id']) ? $user_obj[0]['id'] : '';
            $user_type = isset($user_obj[0]['user_type']) ? $user_obj[0]['user_type'] : '';
            $current_date = date('Y-m-d');
            $current_date = new \DateTime($current_date);
            $start_date = isset($user_obj[0]['start_date']) ? $user_obj[0]['start_date'] : '';
            $start_date = new \DateTime($start_date);
            $end_date = isset($user_obj[0]['end_date']) ? $user_obj[0]['end_date'] : '';
            $end_date = new \DateTime($end_date);
            $is_date_within_range = \App\Models\UtilityModel::isDateBetweenDates($current_date, $start_date, $end_date);
            // print_r($current_date);
            // print_r($start_date);
            // print_r($end_date);
            // dd($is_date_within_range);
            $password_check_status = false;
            $user_pass = trim($user_obj[0]['password']);
            if (Hash::check($password, $user_pass)) {
                $password_check_status = true;
            } else {
                $password_check_status = false;
            }
			
			 
			 $last_login = UserLoginModel::where('user_id',$user_id)->whereRaw("DATE(created_at) >= '".date('Y-m-d',strtotime('-30 days'))."'")->get();			
            if ($user_id && $password_check_status) {
                if ($user_type == 'admin' || $is_date_within_range) {
                   
                    Auth::loginUsingId($user_id);			
					//check if not log in more than 30 days 
                    if(Auth::check()){
                        
                        $user = Auth::user();
                        // Session::put('user_type', $user_type);
                        // session()->put('user_type_1', $user_type);
                        //session(['user_type' => $user_type]);
                       
					
                        if($user_obj[0]['role_id']!='')
                        {
                            $todate = date('Y-m-d');
                            $last_passupdate_time = $user_obj[0]['password_update_time']!=''?date('Y-m-d',strtotime($user_obj[0]['password_update_time'])):date('Y-m-d',strtotime($user_obj[0]['created_at']));
                            $date1=date_create($todate);
                            $date2=date_create($last_passupdate_time);
                            $diff_date = date_diff($date1,$date2);
                            $diff_days = $diff_date->format('%a');
                            if($diff_days > 45)
                            {
                                echo 5;
                            }
                            /*else if(empty($last_login) || count($last_login)==0 || $diff_days >30)
                            {
                                echo 11;
                            }*/
                            else
                            {
                            //Insert The Ip from where the user login in
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $array['user_id'] = $user_id;
                            $array['login_ip'] = $ip;
                            $array['login_type'] = 'Login';
                            $array['created_at'] = Carbon::now();
                            $array['updated_at'] = Carbon::now();
                            UserLoginModel::insertGetId($array);
                            //check if not log in more than 30 days 
                            echo 1;
                            }
                            
                        }
                        else
                        {
                            //Insert The Ip from where the user login in
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $array['user_id'] = $user_id;
                            $array['login_ip'] = $ip;
                            $array['login_type'] = 'Login';
                            $array['created_at'] = Carbon::now();
                            $array['updated_at'] = Carbon::now();
                            UserLoginModel::insertGetId($array);
                            //check if not log in more than 30 days 
                            echo 1;
                        }
                    }else{
                        echo 0;
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
            $res = UserModel::where(['user_name' => $user_name, 'fl_archive' => 'N'])->get()->toArray();
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

    public function loginWithSSO(Request $request)
    {
        $code = $request->query('code');
        if (!empty($code)) {
            $accessToken = $this->getAccessToken($code);
            if (!empty($accessToken)) {
                $userInformation = $this->getUserInformation($accessToken);
		// echo "<pre>";
		// print_r($userInformation);
		// echo "</pre>";die;
                // echo $userInformation['data']['mail'];
                if(!empty($userInformation['data']['mail'])){
                    $user_name = $userInformation['data']['mail'];
                    $user_obj = UserModel::where(['user_name' => $user_name])->get()->toArray();
                    if(!empty($user_obj[0])){
                        Auth::loginUsingId($user_obj[0]['id']);
                        return redirect('/dashboard');
                    }else{
                        session()->flash('error', 'Invalid user credentials');
                        return redirect('/');
                    }
                }else{
                    session()->flash('error', 'Invalid user credentials');
                    return redirect('/');
                }
            }
        } else {
            $params = http_build_query([
                'client_id'     => 'a7d6a97f-94bd-48c8-912c-db6698339b81',
                'response_type' => 'code',
                'redirect_uri'  => 'https://lmsdev.dalmiabharat.com/auth/sso',
                'response_mode' => 'query',
                'scope'         => 'user.read',
            ]);
            return redirect('https://login.microsoftonline.com/62cabb44-c579-4103-b18b-be08807d2114/oauth2/v2.0/authorize?' . $params);
        }
    }

    private function getAccessToken($code)
    {
        $tokenUrl = 'https://login.microsoftonline.com/62cabb44-c579-4103-b18b-be08807d2114/oauth2/v2.0/token';
        $params = [
            'client_id'     => env('SSO_CLIENT_ID'),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => 'https://lmsdev.dalmiabharat.com/auth/sso',
            'client_secret' => env('SSO_CLIENT_SECRET'), // Replace with your client secret
            'scope'         => 'user.read',
        ];
        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            $body = json_decode($response, true);
            if (isset($body['access_token'])) {
                $accessToken = $body['access_token'];
                return $accessToken;
            } else {
                echo "Error: Unable to retrieve access token.";
                print_r($body);
                return false;
            }
        }
        curl_close($ch);
    }

    private function getUserInformation($accessToken)
    {
        $userInfoUrl = 'https://graph.microsoft.com/v1.0/me';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return [
                "status" => false,
                "error" => curl_error($ch),
                "message" => "Error: cURL error:"
            ];
        } else {
            $userInfo = json_decode($response, true);
            if (isset($userInfo['id'])) {
                return [
                    "status" => true,
                    "data" => $userInfo,
                    "message" => "User info fetched successfully."
                ];
            } else {
                return [
                    "status" => false,
                    "data" => $userInfo,
                    "message" => "Error: Unable to retrieve user information."
                ];
            }
        }
        curl_close($ch);
    }
    

}
