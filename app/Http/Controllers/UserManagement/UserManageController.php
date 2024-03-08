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
use App\Models\User\UserModel;
use App\Models\User\UserLoginModel;
use App\Models\User\AssginedStateDistrictModel;
use App\Models\UtilityModel;
use App\Models\Role\Role;
use App\Models\Role\Permission;
use App\Models\Form\FormModel;
use DB;
use Hash;
use JsValidator;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class UserManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [
        //'user.user_name' => 'required',
        'user.role_id' => 'required',
        'user.fl_archive' => 'required',
        'user.start_date' => 'required',
        'user.end_date' => 'required',
    ];
    protected $field_names = [
        //  'user.user_name' => 'Select User',
        'user.role_id' => 'Role',
        'user.fl_archive' => 'Status',
        'user.start_date' => 'Start Date',
        'user.end_date' => 'End Date',
    ];

    public function __construct() {
        parent:: __construct();
        $this->data['data']['cssArr'] = [];
        $this->data['data']['jsArr'] = [];
        $this->data['title'] = 'Dalmia-lams::Track-Management';
        $this->data['data']['jsArr'][] = 'assets/vendor/jsvalidation/js/jsvalidation.js';
        $validator = JsValidator::make($this->validationRules, [], $this->field_names);
        $this->data['validator'] = $validator;
        $states = $this->getAllStates();
        unset($states['']);
        $this->data['states'] = $states;
        $this->middleware('auth');
    }

    public function add($id = null) {
        if ($id == $this->data['current_user_id']) {
            return redirect('unauthorized-access');
        }
        $this->data['pageHeading'] = (!$id) ? 'User Management  <span class="text-danger" >Add</span>' : 'User Management  <span class="text-danger" >Manage</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/dual-list-box/jquery.bootstrap-duallistbox.js';
        $this->data['include_script_view'] = 'admin.UserManagement.script';

        $this->data['id'] = $id;
        if ($id) {

            $user_info = UserModel::where(['id' => $id])->get()->toArray();

            $this->data['user_data'] = $user_info = isset($user_info[0]) ? $user_info[0] : '';
            $crt_id = isset($user_info['crt_id']) ? $user_info['crt_id'] : '';
            if ($crt_id !== $this->data['current_user_id']) {
                return redirect('unauthorized-access');
            }
            $permissions = ($user_info['permissions']) ? explode(",", $user_info['permissions']) : '';
            $selected_states = ($user_info['state']) ? explode(",", $user_info['state']) : '';
            $selected_districts = ($user_info['district']) ? explode(",", $user_info['district']) : '';
            // t($permissions,1);

            $states_str_with_quote = ($selected_states) ? "'" . implode("','", $selected_states) . "'" : '';
            $districts = ($states_str_with_quote) ? $this->getAllDistrictForDropdown($states_str_with_quote, 'multiple_state') : [];
            if ($districts) {
                unset($districts['']);
            }
            // t($districts, 1);

            if (empty($user_info) || $user_info['user_type'] == 'admin') {
                return redirect('user-management/user/add/');
            }
        }
        $this->data['permissions'] = isset($permissions) ? $permissions : '';
        $this->data['state_id'] = isset($selected_states) ? $selected_states : '';
        $this->data['districts'] = isset($districts) ? $districts : '';
        $this->data['selected_districts'] = isset($selected_districts) ? $selected_districts : '';

        //$user_master_list[''] = 'Select';
        $user_master_list = \App\Models\User\MasterUserModel::where(['fl_archive' => 'N', 'assigned' => false])->lists('email', 'email')->toArray();
       // $user_master_list = array_merge(['' => 'Select'], $user_master_list);
        $this->data['user_list'] = ($user_master_list) ? $user_master_list : ['Select'];
        $roles = Role::where(["fl_archive" => 'N'])->lists('display_name', 'id')->toArray();

        $t_roles = array();
        if ($roles) {
            $t_roles[''] = 'Select';
            foreach ($roles as $key => $value) {
                if ($this->user_type !== 'admin') {
                    if ($this->role_name == 'manager' || $this->role_name == 'auditor') {
                        if ($value == 'Data Entry' || $value == 'Superviser') {
                            $t_roles[$key] = $value;
                        }
                    } else if ($this->role_name == 'superviser') {
                        if ($value == 'Data Entry') {
                            $t_roles[$key] = $value;
                        }
                    }
                } else {
                    if ($value == 'Manager' || $value == 'Auditor') {
                        $t_roles[$key] = $value;
                    }
                }
            }
        }
        $this->data['roles'] = $t_roles;
        $this->data['status'] = [
            '' => 'Select',
            'N' => 'Active',
            'Y' => 'Inactive',
        ];

        $cur_user_id = $this->data['current_user_id'];
        $user = UserModel::whereRaw(" id not in ('$cur_user_id')  and crt_id='$cur_user_id' and crt_id='$cur_user_id'")->get()->toArray();
        $this->data['userLists'] = $user;

        $forms = FormModel::where(["fl_archive" => 'N', "status" => 'Y'])->orderBy('sort_order')->get()->toArray();
        $this->data['forms'] = $forms;
        //t($forms,1);
        return view('admin.UserManagement.add', $this->data);
    }

    /*
     * View user log
     */

    public function userLog(Request $request) {
        $this->data['pageHeading'] = 'User Activity Log';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.UserManagement.listscript';

        $posted_data = $request->all();

        $this->data['user_id'] = $user_id = isset($posted_data['user_name']) ? $posted_data['user_name'] : '';
        $this->data['start_date'] = $start_date = isset($posted_data['start_date']) ? $posted_data['start_date'] : '';
        $this->data['end_date'] = $end_date = isset($posted_data['end_date']) ? $posted_data['end_date'] : '';

        $user = UserModel::where(['fl_archive' => 'N'])->lists('user_name', 'id')->toArray();
        $user = array_merge(array('' => 'Select'), $user);
        $this->data['user_list'] = $user;

        $select = 'logged_actions.table_name,logged_actions.action,logged_actions.action_tstamp_tx,logged_actions.client_query,logged_actions.row_data,logged_actions.changed_fields,logged_actions.client_addr,logged_actions.archive,user_name';
        if ($user_id && (!$start_date && !$end_date)) {
            $userSql = "Select $select from audit.logged_actions INNER JOIN \"T_USER\" ON audit.logged_actions.session_user_name=\"T_USER\".id where session_user_name = '{$user_id}' order by event_id DESC";
        } else if ($user_id && $start_date && $end_date) {
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $start_date)));
            $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $end_date)));
            $userSql = "Select $select from audit.logged_actions INNER JOIN \"T_USER\" ON audit.logged_actions.session_user_name=\"T_USER\".id where session_user_name = '{$user_id}' and (action_tstamp_tx between '{$start_date}'' 00:00:00' and '{$end_date}'' 23:59:59') order by event_id DESC";
        } else {
            // $userSql = "Select $select from audit.logged_actions INNER JOIN \"T_USER\" ON audit.logged_actions.session_user_name=\"T_USER\".id";
        }
        $userLogData = '';
        if (isset($userSql)) {
            $userLogData = DB::select(DB::raw($userSql));
        }
        
		//t($userLogData);
		//die();
        $this->data['userLogData'] = $userLogData;
        return view('admin.UserManagement.userLog', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        // t($posted_data, 1);
        $posted_user_data = isset($posted_data['user']) ? $posted_data['user'] : '';

        $user_names = isset($posted_user_data['user_name']) ? $posted_user_data['user_name'] : '';
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';

        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {


            if ($validator->fails()) {
                return redirect('user-management/user/add/' . $id)
                                ->withErrors($validator, 'user')
                                ->withInput();
            }

            $states = isset($posted_data['state']) ? $posted_data['state'] : '';
            $districts = isset($posted_data['district_id']) ? $posted_data['district_id'] : '';
            //t($states,1);

            $permissions = isset($posted_data['permission']) ? $posted_data['permission'] : '';
            $permission_arr = [];
            if ($permissions) {
                foreach ($permissions as $key => $value) {
                    array_push($permission_arr, $key);
                }
            }
            $data_to_update = $posted_user_data;
            $data_to_update['start_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_user_data['start_date'])));
            $data_to_update['end_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_user_data['end_date'])));
            $data_to_update['state'] = ($states) ? implode(",", $states) : '';
            $data_to_update['district'] = ($districts) ? implode(",", $districts) : '';

            if ($districts) {
                $alreadey_assigned_districts = AssginedStateDistrictModel::where(['user_id' => $id])->select('district_id')->get()->toArray();
                //t($alreadey_assigned_districts, 1);
                if ($alreadey_assigned_districts) {
                    foreach ($alreadey_assigned_districts as $e_key => $e_value) {
                        $district_id = $e_value['district_id'];
                        if (!in_array($district_id, $districts)) {
                            $delete = AssginedStateDistrictModel::where(['user_id' => $id, 'district_id' => $district_id])->delete();
                        }
                    }
                }
                foreach ($districts as $key => $value) {
                    $existing_dist = AssginedStateDistrictModel::where(['user_id' => $id, 'district_id' => $value])->get()->toArray();
                    $state_id = \App\Models\Common\DistrictModel::where(['id' => $value])->value('state_id');
                    $data = [
                        'state_id' => $state_id,
                        'district_id' => $value,
                        'user_id' => $id,
                    ];
                    if (empty($existing_dist)) {
                        $data['created_at'] = Carbon::now();
                        $data['crt_id'] = $this->data['current_user_id'];
                        $insert = AssginedStateDistrictModel::insertGetId($data);
                    } else {
                        $data['updated_at'] = Carbon::now();
                        $data['upd_id'] = $this->data['current_user_id'];
                        $update = AssginedStateDistrictModel::where(['user_id' => $id, 'district_id' => $value])->update($data);
                    }
                }
            } else {
               // echo 1233;exit;
                $alreadey_assigned_districts = AssginedStateDistrictModel::where(['user_id' => $id])->select('district_id')->get()->toArray();
                //t($alreadey_assigned_districts, 1);
                if ($alreadey_assigned_districts) {
                    foreach ($alreadey_assigned_districts as $e_key => $e_value) {
                        $district_id = $e_value['district_id'];
                        $delete = AssginedStateDistrictModel::where(['user_id' => $id, 'district_id' => $district_id])->delete();
                    }
                }
            }
            // exit;
            $data_to_update['permissions'] = ($permission_arr) ? implode(",", $permission_arr) : '';
            $data_to_update['upd_id'] = $this->data['current_user_id'];
            $data_to_insert['updated_at'] = Carbon::now();
            $data_to_update['update_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
            //t($data_to_update,1);
            $update = UserModel::where(['id' => $id])->update($data_to_update);
            if ($update) {
                $msg = UtilityModel::getMessage('User data updated successfully!');
                return redirect('user-management/user/add/')->with('message', $msg);
            } else {
                $msg = UtilityModel::getMessage('Something went wrong!', 'error');
                return redirect('user-management/user/add/')->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('user-management/user/add/')
                                ->withErrors($validator, 'user')
                                ->withInput();
            }
            $data_to_insert = $posted_user_data;
            $user_exist_error = [];
            if (!empty($user_names)) {
                foreach ($user_names as $key => $value) {
                    $data_to_insert['user_name'] = $value;
                    $exist_user = UserModel::where(['user_name' => $value])->get()->toArray();
                    if (!empty($exist_user)) {
                        array_push($user_exist_error, $value);
                    } else {
                        $new_password = UtilityModel::randomPassword(8);
                        $new_hashed_password = Hash::make($new_password);
                        $data_to_insert['password'] = $new_password;
			$pass_arr[0] = md5($new_password);
			$data_to_insert['password_history'] = implode(',',$pass_arr);
                        $data_to_insert['start_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_user_data['start_date'])));
                        $data_to_insert['end_date'] = date('Y-m-d', strtotime(str_replace("/", "-", $posted_user_data['end_date'])));
                        $data_to_insert['created_at'] = Carbon::now();
                        //$data_to_insert['updated_at'] = Carbon::now();
                        $data_to_insert['crt_id'] = $this->data['current_user_id'];
                        $data_to_insert['insert_role_id'] = ($this->role_id) ? $this->role_id : 'admin';
                        $insert_id = UserModel::insertGetId($data_to_insert);
                        if ($insert_id) {
                            $send_mail_obj = new \App\Models\SendMailModel();
                            $send_mail_obj->sendWelcomeEmail($insert_id, $new_password);
                        }
                        $update_assigned_status_to_master = \App\Models\User\MasterUserModel::where(['email' => $value])->update(['assigned' => true]);
                    }
                }
            } else {
                $msg = UtilityModel::getMessage('Please Select an User from dropdown', 'error');
                return redirect('user-management/user/add/')->with('message', $msg);
            }
            if (!empty($user_exist_error)) {
                $msg = implode(",", $user_exist_error) . ' already exists';
                $msg = UtilityModel::getMessage($msg, 'error');
            } else {
                $msg = UtilityModel::getMessage('User data saved successfully!');
            }
            return redirect('user-management/user/add/')->with('message', $msg);
        }
    }

    public function loginLog(Request $request) {
//ini_set('memory_limit', '-1');
        $this->data['pageHeading'] = 'User Log';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.UserManagement.listscript';

        $posted_data = $request->all();

        $this->data['user_id'] = $user_id = isset($posted_data['user_name']) ? $posted_data['user_name'] : '';
        $this->data['start_date'] = $start_date = isset($posted_data['start_date']) ? $posted_data['start_date'] : '';
        $this->data['end_date'] = $end_date = isset($posted_data['end_date']) ? $posted_data['end_date'] : '';
		$res = array(); 
        $user = UserModel::where(['fl_archive' => 'N'])->lists('user_name', 'id')->toArray();
        $user = array_merge(array('' => 'Select'), $user);
        $this->data['user_list'] = $user;

        $res = UserLoginModel::where(['user_id' => $user_id])->orderBy('created_at', 'DESC')->get();

        if ($user_id && (!$start_date && !$end_date)) {
            $res = UserLoginModel::where(['user_id' => $user_id])->orderBy('created_at', 'DESC')->get();
        } else if ($user_id && $start_date && $end_date) {
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", $start_date)));
            $end_date = date('Y-m-d', strtotime(str_replace("/", "-", $end_date)));
            $res = UserLoginModel::where(['user_id' => $user_id])->whereBetween('created_at', [$start_date.' 00:00:00', $end_date.' 23:59:59'])->orderBy('created_at', 'DESC')->get();
        } else {
            $res = array(); 
        }
        $this->data['userLoginData'] = $res;
        return view('admin.UserManagement.userLoginLog', $this->data);
    }

    public function districtDropdown(Request $request, $option = true, $json = true) {
        $this->data['typeList'] = $typeList = $request->get('type');
        $this->data['namePrefix'] = $namePrefix = $request->get('namePrefix');
        $this->data['dropdown_type'] = $dropdown_type = $request->get('dropdown_type');
        $this->data['multiple'] = $multiple = $request->get('multiple');
        $manage_user_id = $request->get('manage_user_id');
        $state_id = $request->get('val');
        $assigned_states = explode(",", $state_id);
        $districts_assigned_to_user = [];
        if ($assigned_states) {
            foreach ($assigned_states as $key => $value) {
                $districts = \App\Models\User\AssginedStateDistrictModel::where(['state_id' => str_replace("'", "", $value), 'user_id' => $manage_user_id])->select('district_id')
                                ->get()->toArray();
                // t($districts);
                if ($districts) {
                    foreach ($districts as $dist_key => $dist_value) {
                        $districts_assigned_to_user[] = $dist_value['district_id'];
                    }
                }
            }
        }
        // t($districts_assigned_to_user,1);
        $this->data['districts_assigned_to_user'] = $districts_assigned_to_user;
        if ($typeList == 'district_id') {
            $this->data['label_name'] = $label_name = $request->get('label_name');
            if ($dropdown_type == 'dualbox') {
                $state_id = "'" . str_replace(array("'", ","), array("\\'", "','"), $state_id) . "'";
                $districts = $this->getAllDistrictForDropdown($state_id, 'multiple_state', 'ajax');
                $this->data['optionList'] = $optionList = $districts;
            }
        }
        if ($option == 'true')
            return view('admin.UserManagement.dropdown', $this->data);
        else {
            if ($json == 'true') {

                echo json_encode($optionList);
            } else {
                return $optionList;
            }
        }
    }

    public function unauthorized() {

        $this->data['pageHeading'] = 'Unauthorized Access';
        return view('admin.unauthorized', $this->data);
    }

    public function notFound() {

        $this->data['pageHeading'] = '404 not found';
        return view('404', $this->data);
    }

    public function commonSuccessView() {
        $this->data['pageHeading'] = '';
        return view('admin.common_success_msg', $this->data);
    }

}
