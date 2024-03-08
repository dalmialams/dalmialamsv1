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

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class RoleManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [

        'role.name' => 'required',
        'role.status' => 'required',
    ];
    protected $field_names = [
        'role.name' => 'Role Name',
        'role.status' => 'Status',
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
        $this->data['pageHeading'] = (!$id) ? 'Role Management  <span class="text-danger" >Add</span>' : 'Role Management  <span class="text-danger" >Edit</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.RoleManagement.script';

        $this->data['id'] = $id;
        if ($id) {
            $role_info = Role::where(['id' => $id])->get()->toArray();
            // t($role_info, 1);
            $this->data['role_data'] = isset($role_info[0]) ? $role_info[0] : '';
        }

        $roles = Role::where(['fl_archive' => 'N'])->orderBy('name')->get()->toArray();
        $this->data['roles'] = $roles;
        $this->data['status'] = [
            '' => 'Select',
            'Y' => 'Active',
            'N' => 'Inactive',
        ];
        //t($roles,1);

        return view('admin.RoleManagement.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_role_data = isset($posted_data['role']) ? $posted_data['role'] : '';
       //  t($posted_role_data,1);
        $role_display_name = $posted_role_data['name'];
        $role_name = strtolower($role_display_name);
        $role_name = str_replace(" ", "_", $role_name);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('user-management/role/add/' . $id)
                                ->withErrors($validator, 'user')
                                ->withInput();
            }
            $data_to_update = $posted_role_data;
            $data_to_update['name'] = $role_name;
            $data_to_update['display_name'] = $role_display_name;
            $data_to_update['description'] = $role_display_name;
            $data_to_update['updated_at'] = Carbon::now();
            $update = Role::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Role updated successfully!');
            if ($update) {
                return redirect('user-management/role/add/' . $id)->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('user-management/role/add/')
                                ->withErrors($validator, 'role')
                                ->withInput();
            }
            $existing_role = Role::where(['name' => $role_name])->get()->toArray();
           // t($existing_role,1);
            
            if (empty($existing_role)) {
                $data_to_insert = $posted_role_data;
                $data_to_insert['name'] = $role_name;
                $data_to_insert['display_name'] = $role_display_name;
                $data_to_insert['description'] = $role_display_name;
                $data_to_insert['created_at'] = Carbon::now();
                $data_to_insert['updated_at'] = Carbon::now();
                echo $insert_id = Role::insertGetId($data_to_insert);

                $msg = UtilityModel::getMessage('Role saved successfully!');
                if ($insert_id) {
                    return redirect('user-management/role/add/')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage('Role already exists!', 'error');
                return redirect('user-management/role/add/')->with('message', $msg);
            }
            // t($data_to_insert);
        }
    }

    public function deleteRole($role_id) {
        $deleteRole = Role::where(['id' => $role_id])->update(['fl_archive' => 'Y']);
        $msg = UtilityModel::getMessage('Role deleted successfully!');
        return redirect('user-management/role/add/')->with('message', $msg);
    }

}
