<?php

/*
 * To forgot this license header, choose License Headers in Project Properties.
 * To forgot this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Role\Role;
use App\Models\UtilityModel;
use DB;
use JsValidator;
use Hash;
use Auth;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class ForgotPasswordController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        'password.user_name' => 'required',
    ];
    protected $field_names = [
        'password.user_name' => 'User Name',
    ];
    protected $reset_pwd_validation_rules = [
        'password.new_password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{7,19}$/',
        'password.cnf_new_password' => 'required|same:password.new_password|min:8',
    ];
    protected $reset_pwd_field_names = [
        'password.new_password' => 'New Password',
        'password.cnf_new_password' => 'Confirm New Password',
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Track-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        if (Auth::check()) {
            Auth::logout();
            return redirect('forgot-password');
        }
    }

    public function forgotPassword() {
        $this->data['pageHeading'] = 'Forgot Password';

        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.password.forgot_password_script';

        return view('admin.password.forgot_password', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_password_data = isset($posted_data['password']) ? $posted_data['password'] : '';
        $user_name = isset($posted_password_data['user_name']) ? trim($posted_password_data['user_name']) : '';

        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);

        if ($validator->fails()) {
            return redirect('forgot-password')
                            ->withErrors($validator, 'forgot_pwd')
                            ->withInput();
        } else {
            if ($user_name != 'admin') {
                $existing_user = \App\Models\User\UserModel::where(['user_name' => $user_name])->get()->toArray();
                // t($existing_user,1);
                if (empty($existing_user)) {
                    $msg = UtilityModel::getMessage('Invalid User', 'error');
                    return redirect('forgot-password')->with('message', $msg)->withInput();
                } else {
                    // $old_password_correct = false;
                    $user_id = isset($existing_user[0]['id']) ? $existing_user[0]['id'] : '';
                    $unique_key = UtilityModel::randomKey(20);
                    $encrypt_user_id = base64_encode($user_id);
                    $link = url('reset-password?u=' . $encrypt_user_id . '&key=' . $unique_key);
                    $created_at = date('Y-m-d');
                    $valid_till = strtotime("+7 day", time());
                    $valid_till = date('Y-m-d', $valid_till);
                    $data_to_insert['user_id'] = $user_id;
                    $data_to_insert['unique_key'] = $unique_key;
                    $data_to_insert['link'] = $link;
                    $data_to_insert['created_at'] = $created_at;
                    $data_to_insert['valid_till'] = $valid_till;
                    if ($user_id) {
                        $insert_id = \App\Models\User\ChangePwdLinkModel::insertGetId($data_to_insert);
                        if ($insert_id) {
                            $send_mail_obj = new \App\Models\SendMailModel();
                            $send_mail_obj->sendForgotPasswordEmail($user_id, $link);
                            $msg = UtilityModel::getMessage('A password reset link has been sent to your email which is valid for next 7 days.Please check your'
                                            . ' email inbox');
                            return redirect('forgot-password')->with('message', $msg);
                        } else {
                            $msg = UtilityModel::getMessage('Invalid User', 'error');
                            return redirect('forgot-password')->with('message', $msg)->withInput();
                        }
                    } else {
                        $msg = UtilityModel::getMessage('Invalid User', 'error');
                        return redirect('forgot-password')->with('message', $msg)->withInput();
                    }
                }
            } else {
               // return redirect('/');
			   $msg = UtilityModel::getMessage('Invalid User', 'error');
                return redirect('forgot-password')->with('message', $msg)->withInput();
            }
        }
    }

    public function resetPassword(Request $request) {

        $this->data['pageHeading'] = 'Reset Password';
        $validator = JsValidator::make($this->reset_pwd_validation_rules, [], $this->reset_pwd_field_names);
        $this->data['validator'] = $validator;
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.password.reset_password_script';

        $encrypted_user_id = $request->get('u');
        $key = $request->get('key');
        if (!$encrypted_user_id || !$key) {
            return redirect('forgot-password');
        }

        if ($encrypted_user_id && $key) {
            $user_id = base64_decode($encrypted_user_id);
            $user_forgot_pwd_details = \App\Models\User\ChangePwdLinkModel::where(['user_id' => $user_id, 'unique_key' => $key])->get()->toArray();
            // t($user_forgot_pwd_details,1);
            $used_status = isset($user_forgot_pwd_details[0]['used_status']) ? $user_forgot_pwd_details[0]['used_status'] : '';
            $created_at = isset($user_forgot_pwd_details[0]['created_at']) ? $user_forgot_pwd_details[0]['created_at'] : '';
            $created_at = new \DateTime($created_at);
            $valid_till = isset($user_forgot_pwd_details[0]['valid_till']) ? $user_forgot_pwd_details[0]['valid_till'] : '';
            $valid_till = new \DateTime($valid_till);
            $todayDate = date('Y-m-d');
            $todayDate = new \DateTime($todayDate);
            $isValidDate = UtilityModel::isDateBetweenDates($todayDate, $created_at, $valid_till);
            if ($isValidDate && $used_status == 'N') {
                $this->data['view_form'] = true;
            } else {
                $this->data['view_form'] = false;
                $msg = "The link has been expired.Please try again";
                $this->data['msg'] = UtilityModel::getMessage($msg, 'error');
            }
        } else {
            return redirect('forgot-password');
        }
        $this->data['encrypted_user_id'] = $encrypted_user_id;
        $this->data['user_id'] = $user_id;
        $this->data['key'] = $key;
        return view('admin.password.reset_password', $this->data);
    }

    public function processPasswordResetData(Request $request) {
        $posted_data = $request->all();
        $posted_password_data = isset($posted_data['password']) ? $posted_data['password'] : '';
        $current_password = isset($posted_password_data['current_password']) ? $posted_password_data['current_password'] : '';
        $new_password = isset($posted_password_data['new_password']) ? $posted_password_data['new_password'] : '';
	$encrypted_user_id = isset($posted_data['encrypted_user_id']) ? $posted_data['encrypted_user_id'] : '';
        $user_id = isset($posted_password_data['user_id']) ? $posted_password_data['user_id'] : '';
        $key = isset($posted_password_data['key']) ? $posted_password_data['key'] : '';
        $validator = Validator::make($request->all(), $this->reset_pwd_validation_rules);
        $validator->setAttributeNames($this->reset_pwd_field_names);
        if (!$user_id || !$key) {
            return redirect('forgot-password');
        }
        if ($validator->fails()) {
            return redirect('reset-password?u=' . $encrypted_user_id . '&key=' . $key)
                            ->withErrors($validator, 'reset_pwd')
                            ->withInput();
        } else {
            $hashed_new_password = Hash::make($new_password);
            $data_to_update['password'] = $hashed_new_password;
	    $data_to_update['password_update_time'] = Carbon::now();
            $update_password = \App\Models\User\UserModel::where(['id' => $user_id])->update($data_to_update);

            $forgot_pwd_data['updated_at'] = Carbon::now();
            $forgot_pwd_data['used_status'] = 'Y';
            $update_forgot_pwd_data = \App\Models\User\ChangePwdLinkModel::where(['user_id' => $user_id, 'unique_key' => $key])->update($forgot_pwd_data);
	    
            $msg = UtilityModel::getMessage('Password updated successfully');
            return redirect('forgot-password')->with('message', $msg);
        }
    }

}
