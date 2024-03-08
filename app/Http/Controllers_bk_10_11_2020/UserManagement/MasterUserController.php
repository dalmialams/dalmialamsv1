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
use App\Models\User\MasterUserModel;
use App\Models\UtilityModel;
use DB;
use JsValidator;
/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class MasterUserController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [

        'user.name' => 'required',
        'user.email' => 'required|email',
    ];
    protected $field_names = [
        'user.name' => 'Name',
        'user.email' => 'Email',
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Track-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $this->middleware('auth');
    }

    public function add($id = null) {
        $this->data['pageHeading'] = (!$id) ? 'Master User  <span class="text-danger" >Add</span>' : 'Master User  <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.MasterUser.script';

        $this->data['id'] = $id;
        if ($id) {
            $assgined = MasterUserModel::where(['id' => $id])->value('assigned');
            if ($assgined) {
                return redirect('unauthorized-access');
            }
            $user_info = MasterUserModel::where(['id' => $id])->get()->toArray();
            // t($user_info, 1);
            $this->data['user_data'] = isset($user_info[0]) ? $user_info[0] : '';
        }

        $users = MasterUserModel::where(['fl_archive' => 'N'])->get()->toArray();
        $this->data['users'] = $users;

        return view('admin.MasterUser.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_user_data = isset($posted_data['user']) ? $posted_data['user'] : '';
        // t($posted_user_data, 1);
        $email = $posted_user_data['email'];

        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            $assgined = MasterUserModel::where(['id' => $id])->value('assigned');
            if ($assgined) {
                return redirect('unauthorized-access');
            }
            if ($validator->fails()) {
                return redirect('master-user/add/' . $id)
                                ->withErrors($validator, 'user')
                                ->withInput();
            }
            $data_to_update = $posted_user_data;
            $data_to_insert['upd_id'] = $this->data['current_user_id'];
            $data_to_update['updated_at'] = Carbon::now();
            $update = MasterUserModel::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('MasterUserModel updated successfully!');
            if ($update) {
                return redirect('master-user/add/' . $id)->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('master-user/add')
                                ->withErrors($validator, 'user')
                                ->withInput();
            }
            $existing_user = MasterUserModel::where(['email' => $email])->get()->toArray();
            // t($existing_user,1);
            if (empty($existing_user)) {
                $data_to_insert = $posted_user_data;
                $data_to_insert['crt_id'] = $this->data['current_user_id'];
                $data_to_insert['created_at'] = Carbon::now();
                //  $data_to_insert['updated_at'] = Carbon::now();
                $insert_id = MasterUserModel::insertGetId($data_to_insert);
                $msg = UtilityModel::getMessage('User saved successfully!');
                if ($insert_id) {
                    return redirect('master-user/add')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage('User already exists!', 'error');
                return redirect('master-user/add')->with('message', $msg);
            }
            // t($data_to_insert);
        }
    }

    public function deleteMasterUser($id) {
        $assgined = MasterUserModel::where(['id' => $id])->value('assigned');
        if ($assgined) {
            return redirect('unauthorized-access');
        }
        $deleteFromMaster = MasterUserModel::where(['id' => $id])->delete();
        //$deleteFromUSer = \App\Models\User\UserModel::where(['user_name' => $email])->update(['fl_archive' => 'Y']);
        $msg = UtilityModel::getMessage('User deleted successfully!');
        return redirect('master-user/add/')->with('message', $msg);
    }

}
