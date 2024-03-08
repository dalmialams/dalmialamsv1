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
use App\Models\Role\Permission;
use App\Models\UtilityModel;
use DB;
use JsValidator;

/**
 * Description of SurveyOnDetails
 *
 * @author user-98-pc
 */
class PermissionManageController extends Controller {

    //put your code here
    /**
     * 
     */
    protected $validationRules = [

        'permission.name' => 'required',
    ];
    protected $field_names = [
        'permission.name' => 'Permission Name',
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
        $this->data['pageHeading'] = 'Role Management  <span class="text-danger" >Add</span>';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/select2/select2.js';
        $this->data['data']['jsArr'][] = 'assets/js/formAjaxPlugin.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/validation/jquery.validate.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/jquery.dataTables.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.tableTools.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.bootstrap.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/tables/datatables/dataTables.responsive.js';
        $this->data['data']['jsArr'][] = 'assets/js/pages/tables-data.js';
        $this->data['data']['jsArr'][] = 'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.js';
        $this->data['include_script_view'] = 'admin.PermissionManagement.script';

        $this->data['id'] = $id;
        if ($id) {
            $permission_info = Permission::where(['id' => $id])->get()->toArray();
            // t($permission_info, 1);
            $this->data['permission_data'] = isset($permission_info[0]) ? $permission_info[0] : '';
        }

        $permissions = Permission::all()->toArray();
        $this->data['permissions'] = $permissions;
        //t($permissions,1);

        return view('admin.PermissionManagement.add', $this->data);
    }

    public function processData(Request $request) {
        $posted_data = $request->all();
        $posted_permission_data = isset($posted_data['permission']) ? $posted_data['permission'] : '';
        // t($posted_user_data,1);
        $permission_display_name = $posted_permission_data['name'];
        $permission_name = strtolower($permission_display_name);
        $permission_name = str_replace(" ", "-", $permission_name);
        $id = isset($posted_data['id']) ? $posted_data['id'] : '';
        $validator = Validator::make($request->all(), $this->validationRules);
        $validator->setAttributeNames($this->field_names);
        if ($id) {
            if ($validator->fails()) {
                return redirect('user-management/permission/add/' . $id)
                                ->withErrors($validator, 'permission')
                                ->withInput();
            }
            $data_to_update = $posted_permission_data;
            $data_to_update['name'] = $permission_name;
            $data_to_update['display_name'] = $permission_display_name;
            $data_to_update['description'] = $permission_display_name;
            $data_to_update['updated_at'] = Carbon::now();
            $update = Permission::where(['id' => $id])->update($data_to_update);
            $msg = UtilityModel::getMessage('Permission updated successfully!');
            if ($update) {
                return redirect('user-management/permission/add/' . $id)->with('message', $msg);
            }
        } else {
            if ($validator->fails()) {
                return redirect('user-management/permission/add/')
                                ->withErrors($validator, 'permission')
                                ->withInput();
            }
            $existing_permission = Permission::where(['name' => $permission_name])->get()->toArray();
          //  t($existing_permission, 1);
            if (empty($existing_permission)) {
                $data_to_insert = $posted_permission_data;
                $data_to_insert['name'] = $permission_name;
                $data_to_insert['display_name'] = $permission_display_name;
                $data_to_insert['description'] = $permission_display_name;
                $data_to_insert['created_at'] = Carbon::now();
                $data_to_insert['updated_at'] = Carbon::now();
                $insert_id = Permission::insertGetId($data_to_insert);
                $msg = UtilityModel::getMessage('Permission saved successfully!');
                if ($insert_id) {
                    return redirect('user-management/permission/add/')->with('message', $msg);
                }
            } else {
                $msg = UtilityModel::getMessage('Permission already exists!', 'error');
                return redirect('user-management/permission/add/')->with('message', $msg);
            }
            // t($data_to_insert);
        }
    }

}
