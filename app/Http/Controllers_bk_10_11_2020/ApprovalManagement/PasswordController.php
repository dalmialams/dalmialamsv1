<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Role\Role;
use App\Models\UtilityModel;
use DB;
use JsValidator;
use Hash;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class PasswordController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $changePwdvalidationRules = [
        'password.current_password' => 'required',
        'password.new_password' => 'required|alpha_dash',
        'password.cnf_new_password' => 'required|same:password.new_password|alpha_dash',
    ];
    protected $change_pwd_field_names = [
        'password.current_password' => 'Current Password',
        'password.new_password' => 'New Password',
        'password.cnf_new_password' => 'Confirm New Password',
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Track-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';

        $this->middleware('auth');
    }

    public function changePassword() {
        $this->data['pageHeading'] = 'Change Password';

        $validator = JsValidator::make($this->changePwdvalidationRules, [], $this->change_pwd_field_names);
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
        $this->data['include_script_view'] = 'admin.password.change_password_script';



        return view('admin.password.change_password', $this->data);
    }

    public function processChangePasswordData(Request $request) {
        $posted_data = $request->all();
        $posted_password_data = isset($posted_data['password']) ? $posted_data['password'] : '';
        $current_password = isset($posted_password_data['current_password']) ? $posted_password_data['current_password'] : '';
        $new_password = isset($posted_password_data['new_password']) ? $posted_password_data['new_password'] : '';
        //t($posted_password_data,1);
        $validator = Validator::make($request->all(), $this->changePwdvalidationRules);
        $validator->setAttributeNames($this->change_pwd_field_names);

        if ($validator->fails()) {
            return redirect('change-password')
                            ->withErrors($validator, 'change_pwd')
                            ->withInput();
        } else {
            $existing_hashed_password = \App\Models\User\UserModel::where(['id' => $this->data['current_user_id']])->value('password');
            if (Hash::check($current_password, $existing_hashed_password)) {
                $old_password_correct = true;
            } else {
                $old_password_correct = false;
            }
            if (!$old_password_correct) {
                $msg = UtilityModel::getMessage('Current password is incorrect', 'error');
                return redirect('change-password')->with('message', $msg);
            } else {
                $hashed_new_password = Hash::make($new_password);
                $data_to_update['password'] = $hashed_new_password;
                $update_password = \App\Models\User\UserModel::where(['id' => $this->data['current_user_id']])->update($data_to_update);
                $msg = UtilityModel::getMessage('Password updated successfully');
                return redirect('change-password')->with('message', $msg);
            }
        }
    }

}
